<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\RealEstate\UpdateRequest;
use App\Http\Requests\API\RealEstate\ViewRequest;
use App\Models\RealEstate;
use App\Models\User;
use App\Repositories\AddressRepository;
use App\Repositories\RealEstateRepository;
use App\Transformers\RealEstateTransformer;
use Cache;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

/**
 * Class RealEstateController
 * @package App\Http\Controllers\API
 */
class RealEstateAPIController extends AppBaseController
{
    /** @var  RealEstateRepository */
    private $realEstateRepository;

    /** @var  AddressRepository */
    private $addressRepository;

    public function __construct(RealEstateRepository $realEstateRepo, AddressRepository $addressRepo)
    {
        $this->realEstateRepository = $realEstateRepo;
        $this->addressRepository = $addressRepo;
    }

    /**
     * @return Response
     *
     * @SWG\Get(
     *      path="/realEstate/",
     *      summary="Display the RealEstate",
     *      tags={"RealEstate"},
     *      description="Get RealEstate",
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
     *                  ref="#/definitions/RealEstate"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show(ViewRequest $r)
    {
        /** @var RealEstate $realEstate */
        $realEstate = $this->realEstateRepository->first();
        if (empty($realEstate)) {
            return $this->sendError(__('models.realEstate.errors.not_found'));
        }

        $news_receiver_ids = $realEstate->news_receiver_ids ?? [];
        $realEstate->news_receivers = User::whereIn('id', $news_receiver_ids)->get();

        $response = (new RealEstateTransformer)->transform($realEstate);
        return $this->sendResponse($response, 'Real Estate retrieved successfully');
    }

    /**
     * @param UpdateRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/realEstate",
     *      summary="Update the RealEstate in storage",
     *      tags={"RealEstate"},
     *      description="Update RealEstate",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="RealEstate that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/RealEstate")
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
     *                  ref="#/definitions/RealEstate"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update(UpdateRequest $request)
    {
        $input = $request->all();
        if (key_exists('iframe_url', $input) && is_null($input['iframe_url'])) {
            $input['iframe_url'] = '';
        }

        /** @var RealEstate $realEstate */
        $realEstate = $this->realEstateRepository->first();
        if (empty($realEstate)) {
            return $this->sendError(__('models.realEstate.errors.not_found'));
        }

        // image upload
        $logoFileData = base64_decode($request->get('logo_upload', ''));
        $circleLogoFileData = base64_decode($request->get('circle_logo_upload', ''));
        $tenantLogoFileData = base64_decode($request->get('tenant_logo_upload', ''));
        $faviconIconFileData = base64_decode($request->get('favicon_icon_upload', ''));

        try {
            if ($logoFileData) {
                $input['logo'] = $this->realEstateRepository->uploadImage($logoFileData, $realEstate);
            }
            if ($circleLogoFileData) {
                $fileName = Str::slug(sprintf('%s-%d', $realEstate->name, $realEstate->id)) . '-circle-logo.png';
                $input['circle_logo'] = $this->realEstateRepository->uploadImage($circleLogoFileData, $realEstate, $fileName);
            }
            if ($tenantLogoFileData) {
                $fileName = Str::slug(sprintf('%s-%d', $realEstate->name, $realEstate->id)) . '-tenant-logo.png';
                $input['tenant_logo'] = $this->realEstateRepository->uploadImage($tenantLogoFileData, $realEstate, $fileName);
            }
            if ($faviconIconFileData) {
                $fileName = Str::slug(sprintf('%s-%d', $realEstate->name, $realEstate->id)) . '-favicon-icon.png';
                $input['favicon_icon'] = $this->realEstateRepository->uploadImage($faviconIconFileData, $realEstate, $fileName);
            }
        } catch (\Exception $e) {
            return $this->sendError(__('models.user.errors.image_upload') . $e->getMessage());
        }

        try {
            if (isset($input['address'])) {
                $this->addressRepository->update($input['address'], $realEstate->address_id);
            }
            $input['address_id'] = $realEstate->address_id;
            if (isset($input['login_variation_2_slider'])) {
                $input['login_variation_2_slider'] = (int) $input['login_variation_2_slider'];
            }
            $realEstate = $this->realEstateRepository->update($input, $realEstate->id);
            // Forget weather so the next request to weather
            // brings info from the new location
            Cache::forget('weather_json');
        } catch (\Exception $e) {
            return $this->sendError(__('models.realEstate.errors.update'));
        }
        $realEstate->news_receivers = User::whereIn('id', $realEstate->news_receiver_ids)->get();

        $response = (new RealEstateTransformer)->transform($realEstate);
        return $this->sendResponse($response, __('models.user.realEstateSaved'));
    }
}
