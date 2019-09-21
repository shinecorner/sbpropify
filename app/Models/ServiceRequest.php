<?php

namespace App\Models;

use App\Traits\HasComments;
use App\Traits\UniqueIDFormat;
use Chelout\RelationshipEvents\Concerns\HasMorphedByManyEvents;
use function foo\func;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use PDF;
use Storage;

/**
 * @SWG\Definition(
 *      definition="ServiceRequest",
 *      required={"description", "status", "priority", "due_date"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="category_id",
 *          description="category_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="tenant_id",
 *          description="tenant_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="title",
 *          description="title",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="description",
 *          description="description",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="status",
 *          description="status",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="priority",
 *          description="priority",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="qualification",
 *          description="qualification",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="due_date",
 *          description="due_date",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="solved_date",
 *          description="solved_date",
 *          type="string",
 *          format="date"
 *      ),
 *     @SWG\Property(
 *          property="visibility",
 *          description="visibility",
 *          type="int32"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class ServiceRequest extends AuditableModel implements HasMedia
{
    use SoftDeletes;
    use HasMediaTrait;
    use HasComments;
    use HasMorphedByManyEvents;
    use UniqueIDFormat;

    public $table = 'service_requests';

    const StatusReceived = 1;
    const StatusInProcessing = 2;
    const StatusAssigned = 3;
    const StatusDone = 4;
    const StatusReactivated = 5;
    const StatusArchived = 6;

    const VisibilityTenant = 1;
    const VisibilityBuilding = 2;
    const VisibilityQuarter = 3;

    const PendingStatuses = [
        ServiceRequest::StatusReceived,
        ServiceRequest::StatusInProcessing,
        ServiceRequest::StatusAssigned,
        ServiceRequest::StatusReactivated,
    ];

    const SolvedStatuses = [
        ServiceRequest::StatusDone,
        ServiceRequest::StatusArchived,
    ];

    const Status = [
        self::StatusReceived => 'received',
        self::StatusInProcessing => 'in_processing',
        self::StatusAssigned => 'assigned',
        self::StatusDone => 'done',
        self::StatusReactivated => 'reactivated',
        self::StatusArchived => 'archived',
    ];

    const StatusByTenant = [
        self::StatusReceived => [self::StatusDone],
        self::StatusAssigned => [self::StatusDone, self::StatusArchived],
        self::StatusInProcessing => [self::StatusDone, self::StatusArchived],
        self::StatusDone => [self::StatusReactivated],
        self::StatusReactivated => [self::StatusDone],
        self::StatusArchived => [],
    ];

    const StatusByService = [
        self::StatusReceived => [],
        self::StatusInProcessing => [self::StatusDone],
        self::StatusAssigned => [self::StatusDone],
        self::StatusDone => [self::StatusReactivated],
        self::StatusReactivated => [self::StatusDone],
        self::StatusArchived => [],
    ];

    const StatusByAgent = [
        self::StatusReceived => [self::StatusAssigned],
        self::StatusAssigned => [self::StatusInProcessing, self::StatusDone, self::StatusArchived],
        self::StatusInProcessing => [self::StatusDone, self::StatusArchived],
        self::StatusDone => [self::StatusReactivated, self::StatusArchived],
        self::StatusReactivated => [self::StatusDone, self::StatusArchived],
        self::StatusArchived => [self::StatusReactivated],
    ];

    const Visibility = [
        self::VisibilityTenant => 'tenant',
        self::VisibilityBuilding => 'building',
        self::VisibilityQuarter => 'quarter',
    ];

    const Priority = [
        1 => 'low',
        2 => 'normal',
        3 => 'urgent',
    ];

    const Qualification = [
        1 => 'none',
        2 => 'optical',
        3 => 'sia',
        4 => '2_year_warranty',
        5 => 'cost_consequences',
    ];

    protected $dates = ['deleted_at'];

    const Fillable = [
        'category_id',
        'subject_id',
        'tenant_id',
        'unit_id',
        'title',
        'description',
        'status',
        'priority',
        'internal_priority',
        'due_date',
        'solved_date',
        'qualification',
        'visibility',
        'service_request_format',
        'room',
        'capture_phase',
        'component',
        'payer',
        'location',
        'reactivation_date',
        'resolution_time',
    ];

    public $fillable = self::Fillable;

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'category_id' => 'integer',
        'tenant_id' => 'integer',
        'title' => 'string',
        'description' => 'string',
        'status' => 'integer',
        'priority' => 'integer',
        'internal_priority' => 'integer',
        'due_date' => 'date',
        'solved_date' => 'datetime',
        'qualification' => 'integer',
        'visibility' => 'integer',
        'service_request_format' => 'string',
        'room' => 'string',
        'capture_phase' => 'string',
        'component' => 'string',
        'payer' => 'string',
        'location' => 'integer',
        'reactivation_date' => 'datetime',
        'resolution_time' => 'integer',
    ];

    protected $auditInclude = [
        'category_id',
        'tenant_id',
        'title',
        'status',
        'priority',
        'internal_priority',
        'qualification',
        'due_date',
        'visibility',
        'description',
    ];

    const templateMap = [
        'title' => 'request.title',
        'description' => 'request.description',
        'priority' => 'request.priorityStr',
        'autologinUrl' => '',
        'tenant' => '',
        'category' => '',
        'unit' => '',
        'building' => '',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rulesPost = [
        'title' => 'required|string',
        'description' => 'required|string',
        'priority' => 'required|integer',
        'internal_priority' => 'integer',
        'qualification' => 'required|integer',
        'due_date' => 'required|date',
        'category_id' => 'required|integer',
        'tenant_id' => 'required|integer',
        'visibility' => 'required|integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rulesPostTenant = [
        'title' => 'required|string',
        'description' => 'required|string',
        'category_id' => 'required|integer',
        'priority' => 'required|integer',
        'internal_priority' => 'integer',
        'visibility' => 'required|integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rulesPut = [
        'title' => 'string',
        'description' => 'string',
        'priority' => 'integer',
        'internal_priority' => 'integer',
        'qualification' => 'integer',
        'status' => 'integer',
        'due_date' => 'date',
        'category_id' => 'integer',
        'visibility' => 'required|integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rulesPutTenant = [
        'title' => 'string',
        'description' => 'string',
        'status' => 'integer',
        'priority' => 'required|integer',
        'internal_priority' => 'integer',
        'visibility' => 'required|integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rulesPutService = [
        'status' => 'integer'
    ];

    /**
     * @var array
     */
    protected $auditEvents = [
        AuditableModel::EventCreated,
        AuditableModel::EventUpdated,
        AuditableModel::EventDeleted,
        AuditableModel::EventUserAssigned => 'getAttachedEventAttributes',
        AuditableModel::EventManagerAssigned => 'getAttachedEventAttributes',
        AuditableModel::EventProviderAssigned => 'getAttachedEventAttributes',
        AuditableModel::EventUserUnassigned => 'getDetachedEventAttributes',
        AuditableModel::EventManagerUnassigned => 'getDetachedEventAttributes',
        AuditableModel::EventProviderUnassigned => 'getDetachedEventAttributes',
        AuditableModel::EventProviderNotified => 'getProviderNotifiedEventAttributes'
    ];

    /**
     * @return array
     */
    public function getProviderNotifiedEventAttributes(): array
    {
        $sp = $this->auditData['serviceProvider'];
        $propertyManager = $this->auditData['propertyManager'];
        $mailDetails = $this->auditData['mailDetails'];
        unset($this->auditData);

        return [
            [],
            [
                'service_provider' => [
                    'id' => $sp->id,
                    'name' => $sp->name
                ],
                'property_manager' => [
                    'id' => $propertyManager->id,
                    'first_name' => $propertyManager->first_name,
                    'last_name' => $propertyManager->last_name,
                ],
                'email_title' => $mailDetails['title'],
                'email_cc' => $mailDetails['cc'],
                'email_bcc' => $mailDetails['bcc'],
                'email_to' => $mailDetails['to'],
                'email_body' => $mailDetails['body'],
            ]
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function category()
    {
        return $this->hasOne(ServiceRequestCategory::class, 'id', 'category_id');
    }

    /**
     * @ret1urn \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function tenant()
    {
        return $this->hasOne(Tenant::class, 'id', 'tenant_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'request_tag', 'request_id');
    }

    public function managers()
    {
        return $this->morphedByMany(PropertyManager::class, 'assignee', 'request_assignees', 'request_id');
    }

    public function providers()
    {
        return $this->morphedByMany(ServiceProvider::class, 'assignee', 'request_assignees', 'request_id');
    }

    public function users()
    {
        return $this->morphedByMany(User::class, 'assignee', 'request_assignees', 'request_id');
    }

    public function assignees()
    {
        return $this->hasMany(ServiceRequestAssignee::class, 'request_id');
    }

    public function conversations()
    {
        return $this->morphMany(Conversation::class, 'conversationable');
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection('media');
    }

    public function conversationFor($u1, $u2)
    {
        if ($u1->id == $u2->id) {
            return null;
        }

        foreach ($this->conversations as $c) {
            if (count($c->users) == 2 &&
                $c->users->contains($u1->id) &&
                $c->users->contains($u2->id)) {
                return $c;
            }
        }

        $conv = new Conversation();
        $this->conversations()->save($conv);
        $conv->users()->attach($u1);
        $conv->users()->attach($u2);

        return $conv;
    }

    public function requestsReceived()
    {
        return $this->where('status', ServiceRequest::StatusReceived);
    }

    public function requestsInProcessing()
    {
        return $this->where('status', ServiceRequest::StatusInProcessing);
    }

    public function requestsAssigned()
    {
        return $this->where('status', ServiceRequest::StatusAssigned);
    }

    public function requestsDone()
    {
        return $this->where('status', ServiceRequest::StatusDone);
    }

    public function requestsReactivated()
    {
        return $this->where('status', ServiceRequest::StatusReactivated);
    }

    public function requestsArchived()
    {
        return $this->where('status', ServiceRequest::StatusArchived);
    }

    public function getPriorityStrAttribute()
    {
        return self::Priority[$this->priority];
    }
    public function getInternalPriorityStrAttribute()
    {
        return self::Priority[$this->internal_priority];
    }

    public function getAllPeopleAttribute()
    {
        // @TODO need property managers
        $providers = $this->providers->map(function($p) {
            return $p->user;
        });
        return array_merge([
            $this->tenant->user,
        ], $providers->all(), $this->users->all()) ;
    }

    public function setDownloadPdf(){

       $data = [
            'category' => $this->category,
            'request' => $this,
            'tenant' => $this->tenant->user,
            'language'  => $this->tenant->settings->language
        ];

        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('pdfs.servicerequest.serviceRequestDownload', $data);

        return Storage::disk('service_request_downloads')->put($this->pdfFileName(), $pdf->output());
    }

    public function getDiskPreName()
    {
        return 'requests_';
    }

    public function pdfFileName()
    {
        $language  = $this->tenant->settings->language;

        return $this->id . '-'. $this->tenant->id .'-' . $language . '.pdf';
    }
}
