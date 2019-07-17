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
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

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

    public function adminStats(Request $request)
    {
        [$startDate, $endDate] = $this->getStartDateEndDate($request);
        $ret = [
            'total_requests' => DB::table('service_requests')->count('id'),
            'tenants_per_day' => $this->getDayCountStatistic('tenants', $startDate, $endDate),
            'tenants_per_status' => [],

            'requests_per_status' => [],
            'requests_per_category' => [],

            'products_per_day' => $this->getDayCountStatistic('products', $startDate, $endDate),
            'products_per_status' => [],

            'posts_per_day' => $this->getDayCountStatistic('posts', $startDate, $endDate),
            'posts_per_status' => [],
        ];

        $ret = array_merge($ret, $this->chartRequestByCreationDate($request, false, $startDate, $endDate));
        $ret['requests_per_status'] = $this->chartRequestByStatus($request, false, $startDate, $endDate);
        $ret['tenants_per_status'] = $this->chartRequestByStatus($request, false, $startDate, $endDate, 'tenants');
        $ret['products_per_status'] = $this->chartRequestByStatus($request, false, $startDate, $endDate, 'products');
        $ret['posts_per_status'] = $this->chartRequestByStatus($request, false, $startDate, $endDate, 'posts');

        $categoryDayStatistics = collect($ret['requests_per_day_ydata']);
        $ret['requests_per_category']['labels'] = $categoryDayStatistics->map(function($el) {
            return $el['name'];
        });

        $ret['requests_per_category']['data'] = $categoryDayStatistics->map(function($el) {
            return array_sum($el['data']);
        });

        $avgReqFix = DB::select("select coalesce(floor(avg(time_to_sec(timediff(solved_date, created_at)))), 0) duration
            from service_requests where solved_date is not null;");
        $ret['avg_request_duration'] = $avgReqFix ? gmdate("H:i",$avgReqFix[0]->duration) : 0;

        return $this->sendResponse($ret, 'Admin statistics retrieved successfully');
    }

    /**
     * @param Request $request
     * @param bool $isConvertResponse
     * @param null $startDate
     * @param null $endDate
     * @return mixed
     */
    public function chartRequestByCreationDate(Request $request, $isConvertResponse = true, $startDate = null, $endDate = null)
    {
        if (is_null($startDate) && is_null($endDate)) {
            [$startDate, $endDate] = $this->getStartDateEndDate($request);
        }

        $period = $this->getPeriod($request);
        $parentCategories = ServiceRequestCategory::whereNull('parent_id')->pluck('name', 'id')->toArray();
        [$periodValues, $raw] = $this->getPeriodRelatedData($period, $startDate, $endDate);
        $catDayStats = $this->initializeServiceRequestCategoriesForChart($parentCategories, $periodValues);


        $serviceRequests = ServiceRequest::selectRaw($raw . ', IF(cat2.id IS NULL, cat1.id, cat2.id) AS category_parent_id')
            ->join('service_request_categories AS cat1', 'service_requests.category_id', '=', 'cat1.id')
            ->leftJoin('service_request_categories AS cat2', 'cat1.parent_id', '=', 'cat2.id')
            ->whereDate('service_requests.created_at', '>=', $startDate->format('Y-m-d'))
            ->whereDate('service_requests.created_at', '<=', $endDate->format('Y-m-d'))
            ->groupBy('period')
            ->groupBy('category_parent_id')
            ->get();

        foreach ($serviceRequests as $serviceRequest) {
            $categoryName = $parentCategories[$serviceRequest->category_parent_id] ?? '';
            $catDayStats[$categoryName][$serviceRequest->period] = $serviceRequest->count;
        }

        $formattedReqStatistics = [];
        foreach($catDayStats as $key=>$value){
            $formattedReqStatistics[] = [
                'name' => $key,
                'data' => array_values($value)
            ];
        }

        $ret['requests_per_day_xdata'] = array_values($periodValues);
        $ret['requests_per_day_ydata'] = $formattedReqStatistics;

        return $isConvertResponse
            ? $this->sendResponse($ret, 'Request services statistics formatted successfully')
            : $ret;
    }

    /**
     * @TODO fix many parameters
     *
     * @param Request $request
     * @param bool $isConvertResponse
     * @param null $startDate
     * @param null $endDate
     * @param null $table
     * @return mixed
     */
    public function chartRequestByStatus(Request $request, $isConvertResponse = true, $startDate = null, $endDate = null, $table = null)
    {
        if (is_null($startDate) && is_null($endDate)) {
            [$startDate, $endDate] = $this->getStartDateEndDate($request);
        }

        $tables = [
            'service_requests' => ServiceRequest::class,
            'tenants' => Tenant::class,
            'products' => Product::class,
            'posts' => Post::class,
        ];

        $table = $table ?? $request->table;
        $table  = key_exists($table, $tables) ? $table : 'service_requests';
        $class = $tables[$table];

        $rsPerStatus = $class::selectRaw('status, count(id) `count`')
            ->whereDate('created_at', '>=', $startDate->format('Y-m-d'))
            ->whereDate('created_at', '<=', $endDate->format('Y-m-d'))
            ->groupBy('status')
            ->orderBy('status')
            ->get();

        // Fill missing statuses with a 0 count
        $existingStatuses = $rsPerStatus->pluck('status')->all();
        $classStatus = $class::Status;
        foreach ($classStatus as $status => $__) {
            if (! in_array($status, $existingStatuses)) {
                $stat = new \stdClass;
                $stat->status = $status;
                $stat->count = 0;
                $rsPerStatus->push($stat);
            }
        }

        $response['labels'] = $rsPerStatus->map(function($el) use ($classStatus) {
            return $classStatus[$el->status];
        });

        $response['ids'] = $rsPerStatus->map(function($el) use ($classStatus) {
            return $el->status;
        });

        $response['data'] = $rsPerStatus->map(function($el) {
            return $el->count;
        });

        return $isConvertResponse
            ? $this->sendResponse($response, 'Admin statistics retrieved successfully for ' . $table)
            : $response;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function chartRequestByCategory(Request $request)
    {
        [$startDate, $endDate] = $this->getStartDateEndDate($request);
        $parentCategories = ServiceRequestCategory::whereNull('parent_id')->pluck('name', 'id');
        $serviceRequests = ServiceRequest::selectRaw('count(service_requests.id) as count, IF(cat2.id IS NULL, cat1.id, cat2.id) AS category_parent_id')
            ->join('service_request_categories AS cat1', 'service_requests.category_id', '=', 'cat1.id')
            ->leftJoin('service_request_categories AS cat2', 'cat1.parent_id', '=', 'cat2.id')
            ->whereDate('service_requests.created_at', '>=', $startDate->format('Y-m-d'))
            ->whereDate('service_requests.created_at', '<=', $endDate->format('Y-m-d'))
            ->groupBy('category_parent_id')
            ->get();

        $statisticData = $parentCategories->values()->flip();
        foreach ($statisticData as $category => $__) {
            $statisticData[$category] = 0;
        }

        foreach ($serviceRequests as $serviceRequest) {
            $category = $parentCategories[$serviceRequest->category_parent_id];
            $statisticData[$category] = $serviceRequest->count;
        }

        $response = [
            'labels' => $statisticData->keys(),
            'date' => $statisticData->values()
        ];

        return $this->sendResponse($response, 'Admin statistics retrieved successfully');
    }

    /**
     * @param $table
     * @param null $startDate
     * @param null $endDate
     * @return mixed
     */
    public function getDayCountStatistic($table, $startDate = null, $endDate = null)
    {
        return \DB::table($table)->selectRaw ('date(created_at) `x`, count(id) `y`')
            ->whereDate('created_at', '>=', $startDate->format('Y-m-d'))
            ->whereDate('created_at', '<=', $endDate->format('Y-m-d'))
            ->groupBy('x')
            ->orderBy('x')
            ->get();
    }

    /**
     * @param $parentCategories
     * @param $periodValues
     * @return array
     */
    public function initializeServiceRequestCategoriesForChart($parentCategories, $periodValues)
    {
        $categoryDayStatistic = [];

        foreach($parentCategories as $category){
            foreach ($periodValues as $period => $__) {
                $categoryDayStatistic[$category][$period] = 0;
            }
        }

        return $categoryDayStatistic;
    }

    /**
     * @param $period
     * @param $startDate
     * @param Carbon $endDate
     * @return array
     */
    protected function getPeriodRelatedData($period, $startDate, Carbon $endDate)
    {
        $periodValues = [];

        if ('year' == $period) {
            $part = "YEAR(service_requests.created_at)";
            $startDate->setMonth(1)->setDay(1);
            $endDate->setMonth(12)->setDay(31);
            $currentDate = clone $startDate;

            while ($currentDate < $endDate) {
                $periodValues[$currentDate->year] = $currentDate->year;
                $currentDate->addYear();
            }

        } elseif ('month' == $period) {
            $part = "CONCAT(YEAR(service_requests.created_at), ' ', MONTH(service_requests.created_at))";
            $startDate->setDay(1);
            $endDate->addMonth()->setDay(1)->subDay();

            $currentDate = clone $startDate;
            while ($currentDate < $endDate) {
                $yearMonth = $currentDate->year . ' ' . $currentDate->month;
                $periodValues[$yearMonth] = $currentDate->format('Y M');
                $currentDate->addMonth();
            }
        } elseif ('week' == $period) {

            if ($startDate->dayOfWeek) {
                $startDate = $startDate->subDays($startDate->dayOfWeek);
            }
            if (6 != $endDate->dayOfWeek) {
                $endDate = $endDate->addDays(6 - $endDate->dayOfWeek);
            }
            // @TODO check statistics when WEEK(created_at) = 1, 52, 53 maybe can income some incorrect data
            $part = "CONCAT(YEAR(service_requests.created_at), ' ', WEEK(service_requests.created_at))";
            $currentDate = clone $startDate;
            $today = now();

            while ($currentDate < $endDate) {
                $yearWeek = $currentDate->year . ' ' . $currentDate->week;
                $periodValues[$yearWeek] = ($currentDate->year != $today->year) ? $yearWeek : $currentDate->week;
                $currentDate->addWeek();
            }

        } else {
            $part = "DATE(service_requests.created_at)";
            $datePeriod = CarbonPeriod::create($startDate, $endDate);
            foreach ($datePeriod as $date) {
                $periodValues[$date->format('Y-m-d')] = $date->format('Y-m-d');
            }
        }

        $raw = sprintf("count(service_requests.id) as count, %s as period", $part);


        return [$periodValues, $raw];
    }

    /**
     * @param $request
     * @param null $period
     * @return array
     */
    protected function getStartDateEndDate($request)
    {
        // @TODO fix query param hard code, also key hard code like month
        $requestData = $request->all();

        $startDate = $requestData['start_date'] ?? '';
        $endDate = $requestData['end_date'] ?? '';

        if (empty($startDate) && empty($endDate)) {
            $endDate = now();
            $startDate = now()->subMonth();
        } elseif (empty($startDate)) {
            $endDate = Carbon::parse($endDate);
            $startDate = clone $endDate;
            $startDate->subMonth();
        } elseif (empty($endDate)) {
            $startDate = Carbon::parse($startDate);
            $endDate = now();
        } else {
            $endDate = Carbon::parse($endDate);
            $startDate = Carbon::parse($startDate);
        }

        return [$startDate, $endDate];
    }

    /**
     * @param $request
     * @return string
     */
    protected function getPeriod($request)
    {
        $periods = [
            'day',
            'week',
            'month',
            'year'
        ];
        $period = $request->period ?? 'day';
        return in_array($period, $periods) ? $period : 'day';
    }
}
