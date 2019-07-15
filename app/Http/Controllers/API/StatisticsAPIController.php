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
use Carbon\CarbonPeriod;
use Carbon\Carbon;
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
            'total_requests' => DB::table('service_requests')->count('id'),
            'tenants_per_day' => DB::select("select date(created_at) `x`, count(id) `y` from tenants group by date(created_at) order by `x`;"),
            'tenants_per_status' => [],
                        
            'requests_per_status' => [],
            'requests_per_category' => [],

            'products_per_day' => DB::select("select date(created_at) `x`, count(id) `y` from products group by date(created_at) order by `x`;"),
            'products_per_status' => [],

            'posts_per_day' => DB::select("select date(created_at) `x`, count(id) `y` from posts group by date(created_at) order by `x`;"),
            'posts_per_status' => [],
        ];
        $period_array = $req_array = $formatted_req_array = [];
        
        $period = CarbonPeriod::create(Carbon::now()->subDays(30)->format('Y-m-d'), Carbon::now()->format('Y-m-d'));
        foreach ($period as $date) {            
            $period_array[] = $date->format('Y-m-d');
        }
        $req_parents = collect(DB::select("SELECT id,name from service_request_categories WHERE parent_id IS NULL"));
        foreach($req_parents as $req_parent){
            foreach ($period_array as $date) {
                    $req_array[$req_parent->name][$date] = 0;
                }            
        }        
        $reqPerCreationDate = collect(DB::select("SELECT count(req.id) as cnt_request, date(req.created_at) as created_at, req.category_id, IF(cat2.id IS NULL,cat1.id,cat2.id) AS parent_category_id, IF(cat2.name IS NULL,cat1.name,cat2.name) AS parent_category_name from service_requests as req INNER JOIN service_request_categories AS cat1 on req.category_id = cat1.id LEFT JOIN service_request_categories AS cat2 ON cat1.parent_id = cat2.id GROUP BY parent_category_id, created_at"));
//        print_r($reqPerCreationDate);exit;
        foreach($reqPerCreationDate as $reqValue){
            $req_array[$reqValue->parent_category_name][$reqValue->created_at] = $reqValue->cnt_request;
        }
        $i=0;
        foreach($req_array as $key=>$value){
            $formatted_req_array[$i]['name'] = $key;
            $formatted_req_array[$i]['data'] = array_values($value);
            $i++;        
        }
        $ret['requests_per_day_xdata'] = $period_array;
        $ret['requests_per_day_ydata'] = $formatted_req_array;
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

        $q = "SELECT count(req.id) as cnt_request, IF(parent_cat.id IS NULL,cat.id,parent_cat.id) AS parent_category_id, IF(parent_cat.name IS NULL,cat.name,parent_cat.name) AS parent_category_name from service_requests as req INNER JOIN service_request_categories AS cat on req.category_id = cat.id LEFT JOIN service_request_categories AS parent_cat ON cat.parent_id = parent_cat.id GROUP BY parent_category_id";
        $rsPerCategory = collect(DB::select($q));                
        

        $ret['requests_per_category']['data'] = $rsPerCategory->map(function($el) {
            return $el->cnt_request;
        });
        $ret['requests_per_category']['labels'] = $rsPerCategory->map(function($el) {            
            return $el->parent_category_name;
        });

        $avgReqFix = DB::select("select coalesce(floor(avg(time_to_sec(timediff(solved_date, created_at)))), 0) duration
            from service_requests where solved_date is not null;");
        $ret['avg_request_duration'] = $avgReqFix ? $avgReqFix[0]->duration : 0;

        return $this->sendResponse($ret, 'Admin statistics retrieved successfully');
    }
}
