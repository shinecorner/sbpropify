<?php

namespace App\Repositories;

use App\Models\AuditableModel;
use OwenIt\Auditing\Facades\Auditor;
use App\Mails\NotifyServiceProvider;
use App\Models\Comment;
use App\Models\PropertyManager;
use App\Models\ServiceProvider;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestCategory;
use App\Models\Tenant;
use App\Models\User;
use App\Notifications\NewTenantRequest;
use App\Notifications\RequestCommented;
use App\Notifications\RequestDue;
use App\Notifications\RequestMedia;
use App\Notifications\StatusChangedRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\Models\Media;

/**
 * Class ServiceRequestRepository
 * @package App\Repositories
 * @version February 27, 2019, 2:18 pm UTC
 *
 * @method ServiceRequest findWithoutFail($id, $columns = ['*'])
 * @method ServiceRequest find($id, $columns = ['*'])
 * @method ServiceRequest first($columns = ['*'])
 */
class ServiceRequestRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => 'like',
        'title' => 'like',
        'description' => 'like',
        'status' => 'like',
        'priority' => 'like',
        'internal_priority' => 'like',
        'due_date' => '=',
        'solved_date' => '>=',
        'created_at' => '>=',
    ];

    /**
     * @var array
     */
    protected $mimeToExtension = [
        "image/jpeg" => "jpg",
        "image/png" => "png",
        "application/pdf" => "pdf",
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ServiceRequest::class;
    }

    /**
     * @param array $attributes
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function create(array $attributes)
    {
        $attr = self::getPostAttributes($attributes);

        if (isset($attr['category_id'])) {
            $serviceRequestCategories = ServiceRequestCategory::where('has_qualifications', 1)->pluck('id');
            if (! $serviceRequestCategories->contains($attr['category_id'])) {
                unset($attr['qualification']);
            }
        }
        // Have to skip presenter to get a model not some data
        $temporarySkipPresenter = $this->skipPresenter;
        $this->skipPresenter(true);
        $model = parent::create($attr);
        $this->skipPresenter($temporarySkipPresenter);

        $model = $this->updateRelations($model, $attr);
        $model->save();

        return $this->parserResult($model);
    }

    /**
     * @param array $attributes
     * @param $id
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(array $attributes, $id)
    {
        // Have to skip presenter to get a model not some data
        $temporarySkipPresenter = $this->skipPresenter;
        $this->skipPresenter(true);
        $model = parent::update($attributes, $id);

        $this->skipPresenter($temporarySkipPresenter);

        $model = $this->updateRelations($model, $attributes);
        $model->save();

        return $this->parserResult($model);
    }

    /**
     * @param $attributes
     * @return array
     */
    private static function getPostAttributes($attributes)
    {
        $user = Auth::user();
        if ($user->can('post-request_tenant')) {
            $attr = [];
            $attr['title'] = $attributes['title'];
            $attr['description'] = $attributes['description'];
            $attr['category_id'] = $attributes['category_id'];
            $attr['visibility'] = $attributes['visibility'];
            $attr['priority'] = $attributes['priority'];
            $attr['internal_priority'] = $attributes['internal_priority'] ?? $attributes['priority'];
            $attr['tenant_id'] = $user->tenant->id;
            $attr['unit_id'] = $user->tenant->unit_id;
            $attr['status'] = ServiceRequest::StatusReceived;
            $attr['qualification'] = array_flip(ServiceRequest::Qualification)['none'];

            return $attr;
        }

        if ($user->can('post-request_service')) {
            $attr = [];
            $attr['title'] = $attributes['title'];
            $attr['description'] = $attributes['description'];
            $attr['category_id'] = $attributes['category_id'];
            $attr['tenant_id'] = $user->tenant->id;
            $attr['unit_id'] = $user->tenant->unit_id;
            $attr['status'] = ServiceRequest::StatusReceived;

            return $attr;
        }

        $t = Tenant::find($attributes['tenant_id'] ?? 0);
        $attributes['unit_id'] = $t->unit_id;
        $attributes['assignee_ids'] = [Auth::user()->id];
        $attributes['status'] = ServiceRequest::StatusReceived;
        $attributes['due_date'] = Carbon::parse($attributes['due_date'])->format('Y-m-d');

        return $attributes;
    }

    /**
     * @param $attributes
     * @param $currentStatus
     * @return array
     */
    public static function getPutAttributes($attributes, $currentStatus)
    {
        $user = Auth::user();
        if ($user->can('edit-request_tenant')) {
            $attr = [];
            $attr['title'] = $attributes['title'];
            $attr['description'] = $attributes['description'];
            $attr['category_id'] = $attributes['category_id'];
            $attr['status'] = $attributes['status'];

            return $attr;
        }

        if ($user->can('edit-request_service')) {
            $attr = [];
            $attr['title'] = $attributes['title'];
            $attr['description'] = $attributes['description'];
            $attr['priority'] = $attributes['priority'];

            if (isset($attributes['internal_priority'])) {
                $attr['internal_priority'] = $attributes['internal_priority'];
            }

            $attr['qualification'] = $attributes['qualification'];
            $attr['status'] = $attributes['status'];
            $attr['category_id'] = $attributes['category_id'];
            $attr['tenant_id'] = $attributes['tenant_id'];

            return $attr;
        }

        if ($attributes['status'] != $currentStatus && $attributes['status'] == ServiceRequest::StatusDone) {
            $attributes['solved_date'] = Carbon::now()->format('Y-m-d');
        }

        if (isset($attributes['due_date'])) {
            $attributes['due_date'] = Carbon::parse($attributes['due_date'])->format('Y-m-d');
        }

        return $attributes;
    }

    /**
     * @param $attributes
     * @param $currentStatus
     * @return bool
     */
    public function checkStatusPermission($attributes, $currentStatus)
    {
        if (!isset($attributes['status']) || $currentStatus == $attributes['status']) {
            return true;
        }
        return true;
        $user = Auth::user();
        if ($user->can('edit-request_tenant')) {
            if (!in_array($attributes['status'], ServiceRequest::StatusByTenant[$currentStatus])) {
                return false;
            }
        }

        if ($user->can('edit-request_service')) {
            if (!in_array($attributes['status'], ServiceRequest::StatusByService[$currentStatus])) {
                return false;
            }
        }

        if (!in_array($attributes['status'], ServiceRequest::StatusByAgent[$currentStatus])) {
            return false;
        }

        return true;
    }

    /**
     * @param ServiceRequest $originalRequest
     * @param ServiceRequest $serviceRequest
     */
    public function notifyStatusChange(ServiceRequest $originalRequest, ServiceRequest $serviceRequest)
    {
        if ($originalRequest->status != $serviceRequest->status) {
            $user = $serviceRequest->tenant->user;
            $user->notify(new StatusChangedRequest($serviceRequest, $originalRequest, $user));
        }
    }

    /**
     * @param ServiceRequest $serviceRequest
     */
    public function notifyNewRequest(ServiceRequest $serviceRequest)
    {
        if (!$serviceRequest->tenant->building) {
            return;
        }

        $propertyManagers = PropertyManager::join('building_property_manager', 'property_managers.id', '=', 'building_property_manager.property_manager_id')
            ->where('building_id', $serviceRequest->tenant->building->id)->get();

        $i = 0;
        foreach ($propertyManagers as $propertyManager) {
            $delay = $i++ * env("DELAY_BETWEEN_EMAILS", 10);
            $propertyManager->user->redirect = "/admin/requests/" . $serviceRequest->id;

            $propertyManager->user
                ->notify((new NewTenantRequest($serviceRequest, $propertyManager->user, $serviceRequest->tenant->user))
                    ->delay(now()->addSeconds($delay)));
        }
    }

    /**
     * @param ServiceRequest $serviceRequest
     * @param Comment $comment
     */
    public function notifyNewComment(ServiceRequest $sr, Comment $comment)
    {
        $i = 0;
        foreach ($sr->allPeople as $person) {
            $delay = $i++ * env("DELAY_BETWEEN_EMAILS", 10);

            if ($person->id != $comment->user->id) {
                $person->notify((new RequestCommented($sr, $person, $comment))
                    ->delay(now()->addSeconds($delay)));
            }
        }
    }

    /**
     * @param ServiceRequest $serviceRequest
     * @param User $uploader
     * @param Media $media
     */
    public function notifyMedia(ServiceRequest $sr, User $uploader, Media $media)
    {
        $i = 0;
        foreach ($sr->allPeople as $person) {
            $delay = $i++ * env("DELAY_BETWEEN_EMAILS", 10);

            if ($person->id != $uploader->id) {
                $person->notify((new RequestMedia($sr, $uploader, $media))
                    ->delay(now()->addSeconds($delay)));
            }
        }
    }

    /**
     * @param ServiceRequest $sr
     * @param ServiceProvider $sp
     * @param $propertyManagerUsers
     * @param $mailDetails
     */
    public function notifyProvider(ServiceRequest $sr, ServiceProvider $sp, $propertyManagerUsers, $mailDetails)
    {
        $toEmails = [$sp->user->email];
        if (!empty($mailDetails['to'])) {
            $toEmails[] = $mailDetails['to'];
        }

        $ccEmails = $propertyManagerUsers->pluck('email')->all();

        if (!empty($mailDetails['cc']) && is_array($mailDetails['cc'])) {
            $ccEmails = array_merge($ccEmails, $mailDetails['cc']);
        }

        $bccEmails = $mailDetails['bcc'] ?? [];

        \Mail::to($toEmails)
            ->cc($ccEmails)
            ->bcc($bccEmails)
            ->send( new NotifyServiceProvider($sp, $sr, $mailDetails));

        $auditData = [
            'serviceProvider' => $sp,
            'propertyManagerUsers' => $propertyManagerUsers,
            'mailDetails' => $mailDetails
        ];
        $sr->registerAuditEvent(AuditableModel::EventProviderNotified, $auditData);

        $u = \Auth::user();
        $conv = $sr->conversationFor($u, $sp->user);
        $comment = $mailDetails['title'] . "\n\n" . strip_tags($mailDetails['body']);
        $conv->comment($comment);
        foreach ($propertyManagerUsers as $user) {
            $conv = $sr->conversationFor($u, $user);
            if ($conv) {
                $conv->comment($comment);
            }
        }
    }

    /**
     * @param ServiceRequest $sr
     */
    public function notifyDue(ServiceRequest $sr)
    {
        $beforeHours = env('REQUEST_DUE_MAIL', 24);
        $providers = $sr->providers->map(function($p) {
            return $p->user;
        });

        foreach (array_merge($providers->all(), $sr->managers()->get()->all()) as $u) {
            $u->notify((new RequestDue($sr))->delay($sr->due_date->subHours($beforeHours)));
        }
    }

    public function deleteRequesetWithUnitIds($ids)
    {
        return $this->model->whereIn('unit_id', $ids)->delete();
    }

    public function getRequestCountWithUnitIds($ids)
    {
        return $this->model->whereIn('unit_id', $ids)->count();
    }
}
