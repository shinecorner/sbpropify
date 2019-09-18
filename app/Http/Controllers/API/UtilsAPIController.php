<?php

namespace App\Http\Controllers\API;

use App;
use App\Http\Controllers\AppBaseController;
use App\Models\Post;
use App\Models\Product;
use App\Models\PropertyManager;
use App\Models\ServiceProvider;
use App\Models\ServiceRequest;
use App\Models\TemplateCategory;
use App\Models\Tenant;
use App\Repositories\BuildingRepository;
use App\Repositories\TenantRepository;
use App\Repositories\UnitRepository;
use Config;
use Illuminate\Http\Response;

/**
 * Class UtilsAPIController
 * @package App\Http\Controllers\API
 */
class UtilsAPIController extends AppBaseController
{
    /** @var  BuildingRepository */
    private $buildingRepository;

    /** @var  UnitRepository */
    private $unitRepository;

    /** @var  TenantRepository */
    private $tenantRepository;

    /**
     * UtilsAPIController constructor.
     * @param BuildingRepository $buildingRepo
     * @param UnitRepository $unitRepo
     * @param TenantRepository $tenantRepo
     */
    public function __construct(BuildingRepository $buildingRepo, UnitRepository $unitRepo, TenantRepository $tenantRepo)
    {
        $this->buildingRepository = $buildingRepo;
        $this->unitRepository = $unitRepo;
        $this->tenantRepository = $tenantRepo;
    }

    /**
     * @return Response
     *
     * @SWG\Get(
     *      path="/constants",
     *      summary="Display the app constants",
     *      description="Get he app constants",
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
     *                  ref="#/definitions/Building"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function constants()
    {
        $translations = __('general.languages');
        $languages = config('app.locales');
        foreach ($languages as $key => $__) {
            $languages[$key] = $translations[$key] ?? $languages[$key];
        }

        $app = [
            'languages' => $languages,
        ];

        $re = App\Models\RealEstate::first(['login_variation', 'login_variation_2_slider', 'primary_color', 'primary_color_lighter', 'accent_color', 'logo', 'circle_logo', 'tenant_logo', 'favicon_icon']);

        if ($re) {
            $colors = $re->only(['primary_color', 'accent_color', 'primary_color_lighter']);
            $logo = $re->only(['logo', 'circle_logo', 'favicon_icon', 'tenant_logo']);
            $login = [
                'variation' => $re->login_variation,
                'variation_2_slider' => (bool) $re->login_variation_2_slider,
            ];
        } else {
            $colors = [
                'primary_color_lighter' => '#c55a9059',
                'primary_color' => '#6AC06F',
                'accent_color' => '#F7CA18'
            ];
            $logo = [
                'logo' => null,
                'circle_logo' => null,
                'favicon_icon' => null,
                'tenant_logo' => null,
            ];
            $login = [
                'variation' => 1,
                'variation_2_slider' => true,
            ];
        }
        $response = [
            'app' => $app,
            'buildings' => [],
            'units' => self::getUnitConstants(),
            'tenants' => self::getTenantConstants(),
            'serviceProviders' => self::getServiceProviderConstants(),
            'serviceRequests' => self::getServiceRequestsConstants(),
            'propertyManager' => self::getPropertyManagerConstants(),
            'posts' => self::getPostConstants(),
            'products' => self::getProductConstants(),
            'templates' => self::getTemplateConstants(),
            'audits' => self::getAuditConstants(),
            'colors' => $colors,
            'logo' => $logo,
            'login' => $login
        ];

        return $this->sendResponse($response, 'App constants statistics retrieved successfully');
    }

    private static function getAuditConstants()
    {
        $events = App\Models\AuditableModel::Events;
        return array_combine($events, $events);
    }

    private function getTenantConstants()
    {
        $result = [
            'title' => Tenant::Title,
            'status' => Tenant::Status,
        ];

        return $result;
    }

    private function getUnitConstants()
    {
        $result = [
            'type' => App\Models\Unit::Type,
        ];

        return $result;
    }

    private function getServiceProviderConstants()
    {
        $result = [
            'category' => ServiceProvider::ServiceProviderCategory,
        ];

        return $result;
    }

    private function getServiceRequestsConstants()
    {
        $result = [
            'status' => ServiceRequest::Status,
            'priority' => ServiceRequest::Priority,
            'internal_priority' => ServiceRequest::Priority,
            'qualification' => ServiceRequest::Qualification,
            'statusByTenant' => ServiceRequest::StatusByTenant,
            'statusByService' => ServiceRequest::StatusByService,
            'statusByAgent' => ServiceRequest::StatusByAgent,
            'visibility' => ServiceRequest::Visibility,
        ];

        return $result;
    }

    private function getPropertyManagerConstants()
    {
        $result = [
            'title' => PropertyManager::Title,
        ];

        return $result;
    }

    private function getPostConstants()
    {
        $result = [
            'type' => Post::Type,
            'sub_type' => Post::SubType,
            'visibility' => Post::Visibility,
            'status' => Post::Status,
            'category' => Post::Category,
            'execution_period' => Post::ExecutionPeriod,
        ];

        return $result;
    }

    private function getProductConstants()
    {
        $result = [
            'type' => Product::Type,
            'visibility' => Product::Visibility,
            'status' => Product::Status,
        ];

        return $result;
    }

    private function getTemplateConstants()
    {
        $result = [
            'type' => TemplateCategory::Type,
        ];

        return $result;
    }
}
