<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Models\Building;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestCategory;
use App\Models\Tenant;
use App\Models\Product;
use App\Models\Post;
use App\Repositories\BuildingRepository;
use App\Repositories\ServiceRequestRepository;
use App\Repositories\TenantRepository;
use App\Repositories\UnitRepository;
use Carbon\CarbonInterval;
use Illuminate\Http\Response;
use Validator;
use DB;

/**
 * Class StatisticsAPIController
 * @package App\Http\Controllers\API
 */
class StatisticsAPIController extends AppBaseController
{
    /** @var  BuildingRepository */
    private $buildingRepo;

    /** @var  UnitRepository */
    private $unitRepo;

    /** @var  TenantRepository */
    private $tenantRepo;

    /** @var  ServiceRequestRepository */
    private $serviceRequestRepo;

    public function __construct(
        BuildingRepository $br,
        UnitRepository $ur,
        TenantRepository $tr,
        ServiceRequestRepository $srr)
    {
        $this->buildingRepo = $br;
        $this->unitRepo = $ur;
        $this->tenantRepo = $tr;
        $this->serviceRequestRepo = $srr;
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/buildings/{id}/statistics",
     *      summary="Display the specified Building",
     *      tags={"Building"},
     *      description="Get Building",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Building",
     *          type="integer",
     *          required=true,
     *          in="path"
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
    public function buildingStatistics(int $id)
    {
        /** @var Building $building */
        $building = $this->buildingRepo->findWithoutFail($id);
        if (empty($building)) {
            return $this->sendError('Building not found');
        }

        $tenants = $this->tenantRepo->getTotalTenantsFromBuilding($building->id);
        $units = $this->unitRepo->getTotalUnitsFromBuilding($building->id);

        $occupiedUnits = 0;
        $freeUnit = 0;
        if ($tenants > 0 && $units > 0) {
            $occupiedUnits = round($tenants * 100 / $units);
            $freeUnit = round(($units - $tenants) * 100 / $units);
        }

        $response = [
            'total_tenants' => $tenants,
            'total_units' => $units,
            'occupied_units' => $occupiedUnits,
            'free_units' => $freeUnit,
        ];

        return $this->sendResponse($response, 'Building statistics retrieved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/tenants/{id}/statistics",
     *      summary="Display the specified Tenant statistics",
     *      tags={"Building"},
     *      description="Get Tenants statistics",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Tenant",
     *          type="integer",
     *          required=true,
     *          in="path"
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
     *                  ref="#/definitions/Tenant"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function tenantStatistics(int $id)
    {
        /** @var Tenant $tenant */
        $tenant = $this->tenantRepo->withCount(
            [
                'requests',
                'requestsReceived',
                'requestsInProcessing',
                'requestsAssigned',
                'requestsDone',
                'requestsReactivated',
                'requestsArchived',
            ])->withCount(
            [
                'requests',
                'requestsReceived',
                'requestsInProcessing',
                'requestsAssigned',
                'requestsDone',
                'requestsReactivated',
                'requestsArchived',
            ])->findWithoutFail($id);

        if (empty($tenant)) {
            return $this->sendError('Tenant not found');
        }

        $response = [
            'requests_count' => $tenant->requests_count,
            'opened_requests_count' => $tenant->requests_received_count,
            'pending_requests_count' => $tenant->requests_in_processing_count,
            'done_requests_count' => $tenant->requests_done_count,
            'archived_requests_count' => $tenant->requests_archived_count,

            'requests' => $tenant->requests,
            'opened_requests' => $tenant->requestsReceived,
            'pending_requests' => $tenant->requestsInProcessing,
            'done_requests' => $tenant->requestsDone,
            'archived_requests' => $tenant->requestsArchived,
        ];

        return $this->sendResponse($response, 'Tenant statistics retrieved successfully');
    }

    /**
     * @return Response
     *
     * @SWG\Get(
     *      path="/requests/{id}/statistics",
     *      summary="Display the specified Tenant statistics",
     *      tags={"Building"},
     *      description="Get ServiceRequest statistics",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Tenant",
     *          type="integer",
     *          required=true,
     *          in="path"
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
     *                  ref="#/definitions/Tenant"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function requestsStatistics()
    {
        $serviceReq = (new ServiceRequest);

        try {
            $averageRequestTime = $serviceReq->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, `created_at`, `solved_date`)) as solved')
                ->where('status', ServiceRequest::StatusDone)
                ->first();

            $response = [
                'averageRequestTime' => CarbonInterval::minutes(ceil($averageRequestTime->solved))->cascade()->forHumans(),

                'requestsCount' => $serviceReq->count(),
                'requestsReceivedCount' => $serviceReq->requestsReceived()->count(),
                'requestsInProcessingCount' => $serviceReq->requestsInProcessing()->count(),
                'requestsAssignedCount' => $serviceReq->requestsAssigned()->count(),
                'requestsDoneCount' => $serviceReq->requestsDone()->count(),
                'requestsReactivatedCount' => $serviceReq->requestsReactivated()->count(),
                'requestsArchivedCount' => $serviceReq->requestsArchived()->count(),
            ];

        } catch (\Exception $e) {
            return $this->sendError('ServiceRequest statistics error: ' . $e->getMessage());
        }

        return $this->sendResponse($response, 'Service Request statistics retrieved successfully');
    }

    public function adminStats()
    {
        $ret = [
            'tenants_per_day' => DB::select("select date(created_at) `x`, count(id) `y` from tenants group by date(created_at) order by `x`;"),
            'tenants_per_status' => [],

            'requests_per_day' => DB::select("select date(created_at) `x`, count(id) `y` from service_requests group by date(created_at) order by `x`;"),
            'requests_per_status' => [],
            'requests_per_category' => [],

            'products_per_day' => DB::select("select date(created_at) `x`, count(id) `y` from products group by date(created_at) order by `x`;"),
            'products_per_status' => [],

            'posts_per_day' => DB::select("select date(created_at) `x`, count(id) `y` from posts group by date(created_at) order by `x`;"),
            'posts_per_status' => [],
        ];

        $rsPerStatus = collect(DB::select("select status `status`, count(id) `count` from service_requests group by status order by status;"));
        // Fill missing statuses with a 0 count
        foreach (ServiceRequest::Status as $status => $__) {
            if (!$rsPerStatus->contains(function($val) use ($status) {
                return $val->status == $status;
            })) {
                $stat = new \stdClass;
                $stat->status = $status;
                $stat->count = 0;
                $rsPerStatus->push($stat);
            }
        }
        $ret['requests_per_status']['data'] = $rsPerStatus->map(function($el) {
            return $el->count;
        });
        $ret['requests_per_status']['labels'] = $rsPerStatus->map(function($el) {
            return ServiceRequest::Status[$el->status];
        });

        $tsPerStatus = collect(DB::select("select status `status`, count(id) `count` from tenants group by status order by status;"));
        // Fill missing statuses with a 0 count
        foreach (Tenant::Status as $status => $__) {
            if (!$tsPerStatus->contains(function($val) use ($status) {
                return $val->status == $status;
            })) {
                $stat = new \stdClass;
                $stat->status = $status;
                $stat->count = 0;
                $tsPerStatus->push($stat);
            }
        }
        $ret['tenants_per_status']['data'] = $tsPerStatus->map(function($el) {
            return $el->count;
        });
        $ret['tenants_per_status']['labels'] = $tsPerStatus->map(function($el) {
            return Tenant::Status[$el->status];
        });


        $prodsPerStatus = collect(DB::select("select status `status`, count(id) `count` from products group by status order by status;"));
        // Fill missing statuses with a 0 count
        foreach (Product::Status as $status => $__) {
            if (!$prodsPerStatus->contains(function($val) use ($status) {
                return $val->status == $status;
            })) {
                $stat = new \stdClass;
                $stat->status = $status;
                $stat->count = 0;
                $prodsPerStatus->push($stat);
            }
        }
        $ret['products_per_status']['data'] = $prodsPerStatus->map(function($el) {
            return $el->count;
        });
        $ret['products_per_status']['labels'] = $prodsPerStatus->map(function($el) {
            return Product::Status[$el->status];
        });

        $postsPerStatus = collect(DB::select("select status `status`, count(id) `count` from posts group by status order by status asc;"));
        // Fill missing statuses with a 0 count
        foreach (Post::Status as $status => $__) {
            if (!$postsPerStatus->contains(function($val) use ($status) {
                return $val->status == $status;
            })) {
                $stat = new \stdClass;
                $stat->status = $status;
                $stat->count = 0;
                $postsPerStatus->push($stat);
            }
        }
        $ret['posts_per_status']['data'] = $postsPerStatus->map(function($el) {
            return $el->count;
        });
        $ret['posts_per_status']['labels'] = $postsPerStatus->map(function($el) {
            return Post::Status[$el->status];
        });

        $q = "select service_request_categories.name `category`, category_id, coalesce(parent_categs.name, '') `parent_name`, count(service_requests.id) `count`
            from service_requests
            join service_request_categories on category_id = service_request_categories.id
            left join service_request_categories parent_categs on parent_categs.id = service_request_categories.parent_id
            group by category_id order by service_request_categories.id;";
        $rsPerCategory = collect(DB::select($q));
        foreach (ServiceRequestCategory::all() as $rCateg) {
            if (!$rsPerCategory->contains(function($val) use ($rCateg) {
                return $val->category_id == $rCateg->id;
            })) {
                $stat = new \stdClass;
                $stat->category = $rCateg->name;
                $stat->category_id = $rCateg->id;
                $stat->parent_name = $rCateg->parentCategory ? $rCateg->parentCategory->name : "";
                $stat->count = 0;
                $rsPerCategory->push($stat);
            }
        }

        $ret['requests_per_category']['data'] = $rsPerCategory->map(function($el) {
            return $el->count;
        });
        $ret['requests_per_category']['labels'] = $rsPerCategory->map(function($el) {
            if ($el->parent_name) {
                return $el->parent_name . '.' . $el->category;
            }
            return $el->category;
        });

        $avgReqFix = DB::select("select coalesce(floor(avg(time_to_sec(timediff(solved_date, created_at)))), 0) duration
            from service_requests where solved_date is not null;");
        $ret['avg_request_duration'] = $avgReqFix ? $avgReqFix[0]->duration : 0;

        return $this->sendResponse($ret, 'Admin statistics retrieved successfully');
    }
}
