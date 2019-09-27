<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\Notification\EditRequest;
use App\Http\Requests\API\Notification\ListRequest;
use App\Transformers\NotificationTransformer;

/**
 * Class NotificationController
 * @package App\Http\Controllers\API
 */

class NotificationAPIController extends AppBaseController
{
    /**
     * @var NotificationTransformer
     */
    private $transformer;

    /**
     * NotificationAPIController constructor.
     * @param NotificationTransformer $nTrans
     */
    public function __construct(NotificationTransformer $nTrans)
    {
        $this->transformer = $nTrans;
    }

    /**
     * @SWG\Get(
     *      path="/notifications",
     *      summary="Get a listing of the notifications.",
     *      tags={"Notification"},
     *      description="Get all Notifications",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items()
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     *
     * @param ListRequest $request
     * @return mixed
     */
    public function index(ListRequest $request)
    {
        $perPage = $request->get('per_page', env('APP_PAGINATE', 10));
        $user = $request->user();
        $notifications = $user->notifications()->paginate($perPage);

        $notifications->map(function ($item) use ($user) {
            $item->setRelation('user', $user);
        });
        $out = $this->transformer->transformPaginator($notifications);
        return $this->sendResponse($out, 'Notifications retrieved successfully');
    }

    /**
     * @SWG\Post(
     *      path="/notifications/{id}",
     *      summary="Mark a notification as read/unread",
     *      tags={"Notification"},
     *      description="Update notification",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     *
     * @param $id
     * @param EditRequest $request
     * @return mixed
     */
    public function markAsReadUnRead($id, EditRequest $request)
    {
        $notification = $request->user()->notifications()
            ->where('id', $id)
            ->first();
        if ($notification) {
            $notification->read_at = $notification->read_at ? null : now();
            $notification->save();

        }

        $notification->setRelation('user', $request->user());
        $response = (new NotificationTransformer)->transform($notification);
        return $this->sendResponse($response, 'Notification marked successfully');
    }

    /**
     * @SWG\Post(
     *      path="/notifications",
     *      summary="Mark all notifications as read",
     *      tags={"Notification"},
     *      description="Update notifications",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     *
     * @param EditRequest $request
     * @return mixed
     */
    public function markAllAsRead(EditRequest $request)
    {
        $marked = $request->user()->unreadNotifications()
            ->get()->markAsRead();
        return $this->sendResponse($marked, 'Notifications marked successfully');
    }
}
