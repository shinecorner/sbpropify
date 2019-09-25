<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\UserSetting\UpdateRequest;
use App\Http\Requests\API\UserSetting\UpdateLoggedInRequest;
use App\Models\User;
use App\Repositories\UserSettingsRepository;

/**
 * Class UserSettingsController
 * @package App\Http\Controllers\API
 */
class UserSettingsAPIController extends AppBaseController
{
    /** @var  UserSettingsRepository */
    private $userSettingsRepository;

    /**
     * UserSettingsAPIController constructor.
     * @param UserSettingsRepository $userSettingsRepo
     */
    public function __construct(UserSettingsRepository $userSettingsRepo)
    {
        $this->userSettingsRepository = $userSettingsRepo;
    }

    /**
     * @SWG\Put(
     *      path="/users/{user_id}",
     *      summary="Update the specified UserSettings in storage",
     *      tags={"User"},
     *      description="Update UserSettings",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of UserSettings",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="UserSettings that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/UserSettings")
     *      ),
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
     *                  ref="#/definitions/UserSettings"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     *
     * @param $userId
     * @param UpdateRequest $request
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function update($userId, UpdateRequest $request)
    {
        $input = $request->all();
        $user = (new User)->find($userId);

        if (empty($user)) {
            return $this->sendError(__('models.user.not_found'));
        }

        $userSettings = $this->userSettingsRepository->updateExisting($user->settings, $input);

        return $this->sendResponse($userSettings->toArray(), __('models.user.notificationSaved'));
    }

    /**
     * @SWG\Put(
     *      path="/users/me/settings",
     *      summary="Update the Logged In UserSettings in storage",
     *      tags={"User"},
     *      description="Update UserSettings",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="UserSettings that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/UserSettings")
     *      ),
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
     *                  ref="#/definitions/UserSettings"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     *
     * @param UpdateLoggedInRequest $request
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function updateLoggedIn(UpdateLoggedInRequest $request)
    {
        $input = $request->all();
        $user = $request->user();
        $userSettings = $this->userSettingsRepository->updateExisting($user->settings, $input);

        return $this->sendResponse($userSettings->toArray(), __('models.user.notificationSaved'));
    }
}
