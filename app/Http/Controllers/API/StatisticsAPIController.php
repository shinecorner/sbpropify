<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Models\Building;
use App\Models\LoginDevice;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestCategory;
use App\Models\State;
use App\Models\Tenant;
use App\Models\Product;
use App\Models\Post;
use App\Models\Unit;
use App\Models\UserSettings;
use App\Repositories\BuildingRepository;
use App\Repositories\ServiceRequestRepository;
use App\Repositories\TenantRepository;
use App\Repositories\UnitRepository;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

/**
 * @TODO authorize each request
 *
 * Class StatisticsAPIController
 * @package App\Http\Controllers\API
 */
class StatisticsAPIController extends AppBaseController
{
    const YEAR = 'year';
    const MONTH = 'month';
    const WEEK = 'week';
    const DAY = 'day';
    const DEFAULT_PERIOD = self::DAY;
    const PERMITTED_PERIODS = [
        self::DAY,
        self::WEEK,
        self::MONTH,
        self::YEAR,
    ];

    const PERMITTED_HEAT_PERIODS = [
        self::WEEK,
        self::YEAR,
    ];

    /**
     *
     *      @SWG\Parameter(
     *          name="start_date",
     *          in="query",
     *          description="format: dd.mm.yyyy | example: 19.06.2019 | Get statistic after correspond value. It is corrected by period value | default value is one month ago of end_date",
     *          type="string",
     *          format="full-date"
     *      ),
     *      @SWG\Parameter(
     *          name="end_date",
     *          in="query",
     *          description="format: dd.mm.yyyy | example: 19.07.2019 | Get statistic before correspond value. It is corrected by period value | default value today",
     *          type="string",
     *          format="full-date"
     *      ),
     *      @SWG\Parameter(
     *          name="period",
     *          in="query",
     *          description="get statistic by period related start_date, end_date",
     *          type="string",
     *          default="day",
     *          enum={"day", "week", "month", "year"}
     *      ),
     *
     *      @SWG\Definition(
     *          definition="StatisticByCreationDate",
     *              @SWG\Property(
     *                  property="requests_per_day_xdata",
     *                  type="array",
     *                  items={"type"="string", "format"="full-date"},
     *                  example={"01.07.2019", "02.07.2019", ".......", "01.08.2019"}
     *              ),
     *              @SWG\Property(
     *                  property="requests_per_day_ydata",
     *                  type="array",
     *                  items={
     *                      "type"="object",
     *                  },
     *                  example={
     *                      {
     *                          "name"="unpublished",
     *                          "data"={0,1, "..."}
     *                      },
     *                      ".....",
     *                      {
     *                          "name"="published",
     *                          "data"={0,1, "..."}
     *                      },
     *                  }
     *              ),
     *          )
     *      )
     *      @SWG\Definition(
     *          definition="Donut",
     *          @SWG\Property(
     *              property="labels",
     *              description="Labels for statistics",
     *              type="array",
     *              items={"type"="string"},
     *              example={"received", "in_processing", "....."}
     *          ),
     *          @SWG\Property(
     *              property="ids",
     *              description="key correspond labels",
     *              type="array",
     *              items={"type"="string"},
     *              example={"1", "2", "..."}
     *          ),
     *          @SWG\Property(
     *              property="data",
     *              description="data correspond labels",
     *              type="array",
     *              items={"type"="integer"},
     *              example={"65", "130", "..."}
     *          ),
     *          @SWG\Property(
     *              property="tag_percentage",
     *              description="percentage correspond data",
     *              type="array",
     *              items={"type"="integer"},
     *              example={"30", "60"}
     *          )
     *      )
     *
     */
    const QUERY_PARAMS = [
        'year' => 'year',
        'period' => 'period',
        'date' => 'date',
        'start_date' => 'start_date',
        'end_date' => 'end_date',
        'table' => 'table',
        'column' => 'column'
    ];

    /**
     * table,column config for make DonutChart
     *
     * this is use for permit correct table and column value
     * also according this config can get default values
     *
     * if not set table optional parameter or write not permitted table name that case must be get data
     * for this table and must be group by first value of self::PERMITTED_TABLES_GROUP[self::DEFAULT_TABLE]['column']

     */
    const PERMITTED_TABLES_GROUP = [
        'service_requests' => [
            'class' => ServiceRequest::class,
            'columns' => [
                'status'
            ]
        ],
        'tenants' => [
            'class' => Tenant::class,
            'columns' => [
                'status',
                'title' => [
                    'mr' => 'mr',
                    'mrs' => 'mrs',
                    'company' => 'company',
                ],
            ]
        ],
        'products' => [
            'class' => Product::class,
            'columns' => [
                'status',
                'type'
            ]
        ],
        'posts' => [
            'class' => Post::class,
            'columns' => [
                'status',
                'type'
            ]
        ],
    ];

    const PERMITTED_TABLES_FOR_CREATED_DATE = [
        'products' => [
            'class' => Product::class,
            'columns' => [
                'status',
            ]
        ],
        'tenants' => [
            'class' => Tenant::class,
            'columns' => [
                'status',
            ]
        ],
        'posts' => [
            'class' => Post::class,
            'columns' => [
                'status',
            ]
        ],
    ];

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
            return $this->sendError(__('models.building.errors.not_found'));
        }

        $tenants = $this->tenantRepo->getTotalTenantsFromBuilding($building->id);
        $units = Unit::where('building_id', $id)->count();
        $occupiedUnitsCount = Unit::where('building_id', $id)->has('tenant')->count();

        if ($units) {
            $occupiedUnits = round($occupiedUnitsCount * 100 / $units);
            $freeUnit = 100 - $occupiedUnits;
        } else {
            $occupiedUnits = 0;
            $freeUnit = 0;
        }

        $response = [
            'total_tenants' => $this->thousandsFormat($tenants),
            'total_units' => $this->thousandsFormat($units),
            'occupied_units' => $this->thousandsFormat($occupiedUnits),
            'free_units' => $this->thousandsFormat($freeUnit),
        ];

        return $this->sendResponse($response, 'Building statistics retrieved successfully');
    }

    /**
     * @return array
     */
    protected function allBuildingStatistics()
    {
        $unitCount = Unit::count();
        $occupiedUnitsCount = Unit::has('tenant')->count();

        if ($unitCount) {
            $occupiedUnits = round($occupiedUnitsCount * 100 / $unitCount);
            $freeUnit = 100 - $occupiedUnits;
        } else {
            $occupiedUnits = 0;
            $freeUnit = 0;
        }


        $tenantCount = $this->tenantRepo->count();
        $unitCount = $this->unitRepo->count();

        /**
         * @TODO adjust response for frontend
         */
        $response = [
            'total_tenants' => $this->thousandsFormat($tenantCount),
            'total_units' => $this->thousandsFormat($unitCount),
//            'occupied_units' => $occupiedUnits,
//            'free_units' => $freeUnit,
            'labels' => [
                'occupied_units',
                'free_units'
            ],
            'data' => [
                $this->thousandsFormat($occupiedUnitsCount),
                $this->thousandsFormat($unitCount - $occupiedUnitsCount)
            ],
            'tag_percentage' => [
                $occupiedUnits,
                $freeUnit
            ],
        ];

        return $response;
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
        $tenant = $this->tenantRepo
            ->scope('allRequestStatusCount')
            ->withCount('requests')
            ->findWithoutFail($id);

        if (empty($tenant)) {
            return $this->sendError(__('models.tenant.errors.not_found'));
        }

        $response = [
            'requests_count' => $this->thousandsFormat($tenant->requests_count),
            'opened_requests_count' => $this->thousandsFormat($tenant->requests_received_count),
            'pending_requests_count' => $this->thousandsFormat($tenant->requests_in_processing_count),
            'done_requests_count' => $this->thousandsFormat($tenant->requests_done_count),
            'archived_requests_count' => $this->thousandsFormat($tenant->requests_archived_count),

            'requests' => $this->thousandsFormat($tenant->requests),
            'opened_requests' => $this->thousandsFormat($tenant->requestsReceived),
            'pending_requests' => $this->thousandsFormat($tenant->requestsInProcessing),
            'done_requests' => $this->thousandsFormat($tenant->requestsDone),
            'archived_requests' => $this->thousandsFormat($tenant->requestsArchived),
        ];

        return $this->sendResponse($response, 'Tenant statistics retrieved successfully');
    }

    /**
     * @SWG\Get(
     *      path="/tenants/gender-statistics",
     *      summary="Tenants gender statistics for Donut Chart",
     *      tags={"Tenant", "Donut"},
     *      description="Get tenants gender statistics",
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
     *                  type="object",
     *                  @SWG\Property(
     *                      property="labels",
     *                      description="Labels for statistics",
     *                      type="array",
     *                      items={"type"="string"},
     *                      example={"mr", "mrs"}
     *                  ),
     *                  @SWG\Property(
     *                      property="data",
     *                      description="data correspond labels",
     *                      type="array",
     *                      items={"type"="integer"},
     *                      example={"65", "72"}
     *                  ),
     *                  @SWG\Property(
     *                      property="tag_percentage",
     *                      description="percentage correspond data",
     *                      type="array",
     *                      items={"type"="integer"},
     *                      example={"47", "53"}
     *                  ),
     *                  @SWG\Property(
     *                      property="average_age",
     *                      description="associative array show average emage",
     *                      type="object",
     *                      @SWG\Property(
     *                          property="mr",
     *                          description="data correspond labels",
     *                          type="integer",
     *                          example=30
     *                      ),
     *                      @SWG\Property(
     *                          property="mrs",
     *                          description="data correspond labels",
     *                          type="integer",
     *                          example=24
     *                      ),
     *                      @SWG\Property(
     *                          property="both",
     *                          description="data correspond labels",
     *                          type="integer",
     *                          example=26
     *                      )
     *                  )
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string",
     *              )
     *          )
     *      )
     * )
     *
     * @return mixed
     */
    public function tenantsGenderStatistics()
    {
        $tenants = Tenant::selectRaw('count(id) as count, title')
            ->whereIn('title', ['mr', 'mrs'])
            ->groupBy('title')
            ->get();
        $manCount = $tenants->where('title', 'mr')->first()->count ?? 0;
        $femaleCount = $tenants->where('title', 'mrs')->first()->count ?? 0;
        if ($manCount + $femaleCount == 0) {
            $response = [
                'labels' => [
                    'mr',
                    'mrs'
                ],
                'data' => [
                    0,
                    0
                ],
                'tag_percentage' => [
                    0,
                    0
                ],
                'average_age' => [
                    'mr' => 0,
                    'mrs' => 0,
                    'both' => 0
                ]
            ];
            return $this->sendResponse($response, 'Tenants gender statistics retrieved successfully');
        }


        $femalePercentage = round($femaleCount * 100 / ($femaleCount + $manCount));


        $tenantsAge = Tenant::selectRaw('FROM_UNIXTIME(AVG(UNIX_TIMESTAMP(birth_date))) AS duration, title')
            ->whereIn('title', ['mr', 'mrs'])
            ->groupBy('title')
            ->get();
        $bothTenants = Tenant::selectRaw('FROM_UNIXTIME(AVG(UNIX_TIMESTAMP(birth_date))) AS duration')
            ->whereIn('title', ['mr', 'mrs'])
            ->value('duration');

        $femaleAvgAge = $tenantsAge->where('title', 'mrs')->first()->duration ?? 0;
        $manAvgAge = $tenantsAge->where('title', 'mr')->first()->duration ?? 0;

        $response = [
            'labels' => [
                'mr',
                'mrs'
            ],
            'data' => [
                $this->thousandsFormat($manCount),
                $this->thousandsFormat($femaleCount),
            ],
            'tag_percentage' => [
                100 - $femalePercentage,
                $femalePercentage
            ],
            'average_age' => [
                'mr' => Carbon::parse($manAvgAge)->age,
                'mrs' => Carbon::parse($femaleAvgAge)->age,
                'both' => Carbon::parse($bothTenants)->age
            ]
        ];

        return $this->sendResponse($response, 'Tenants gender statistics retrieved successfully');
    }

    /**
     * @return mixed
     */
    public function tenantsAgeStatistics()
    {
        // @TODO check permission in request
        $ageConfig = [
            '18-25' => [
                ['>=', 25]
            ],
            '25-35' => [
                ['>=', 35],
                ['<', 25]
            ],
            '35-45' => [
                ['>=', 45],
                ['<', 35]
            ],
            '45-55' => [
                ['>=', 55],
                ['<', 45]
            ],
            '55-65' => [
                ['>=', 65],
                ['<', 55]
            ],
            '>=65' => [
                ['<=', 65],
            ],
        ];


        $query = $this->getQueryForAge($ageConfig);
        $result = \App\Models\Tenant::selectRaw($query)->first();
        $columnValues = array_combine(array_keys($ageConfig), array_keys($ageConfig));

        $statistics = collect();
        foreach ($columnValues as $key => $value) {
            $statistics->push([
                'age' => $key,
                'count' => $result->{(string)$key}
            ]);
        }


        $response = $this->formatForDonutChart($statistics, 'age', $columnValues, true);
        return $this->sendResponse($response, 'Tenants gender statistics retrieved successfully');
    }

    /**
     * @param $agesConfig
     * @return string
     */
    protected function getQueryForAge($agesConfig)
    {
        $query = '';

        foreach ($agesConfig as $label => $conditions) {
            $conditionQuery = '';
            foreach ($conditions as $condition) {
                $conditionQuery .= 'birth_date ' . $condition[0] . ' "' . now()->subYear($condition[1])->format('Y-m-d') . '" and ';
            }
            $conditionQuery = rtrim($conditionQuery, ' and ');
            $query .= sprintf('count(case when %s then 1 end) AS `%s`, ', $conditionQuery,  $label);
        }

        return rtrim($query, ', ');
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

                'requestsCount' => $this->thousandsFormat($serviceReq->count()),
                'requestsReceivedCount' => $this->thousandsFormat($serviceReq->requestsReceived()->count()),
                'requestsInProcessingCount' => $this->thousandsFormat($serviceReq->requestsInProcessing()->count()),
                'requestsAssignedCount' => $this->thousandsFormat($serviceReq->requestsAssigned()->count()),
                'requestsDoneCount' => $this->thousandsFormat($serviceReq->requestsDone()->count()),
                'requestsReactivatedCount' => $this->thousandsFormat($serviceReq->requestsReactivated()->count()),
                'requestsArchivedCount' => $this->thousandsFormat($serviceReq->requestsArchived()->count()),
            ];

        } catch (\Exception $e) {
            return $this->sendError(__('models.request.errors.statistics_error') . $e->getMessage());
        }

        return $this->sendResponse($response, 'Service Request statistics retrieved successfully');
    }

    /**

     * @SWG\Get(
     *      path="/admin/statistics",
     *      summary="statistics for request, building, post, product",
     *      tags={"ServiceRequest", "Post", "Tenant", "Product"},
     *      description="statistics for request, building, post, product",
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
     *                  type="object",
     *                  @SWG\Property(
     *                      property="avg_request_duration",
     *                      type="string",
     *                      example="01:07"
     *                  ),
     *                  @SWG\Property(
     *                      property="total_requests",
     *                      type="string",
     *                      example="1'000"
     *                  ),
     *                  @SWG\Property(
     *                      property="requests_per_status",
     *                      ref="#/definitions/Donut"
     *                  ),
     *                  @SWG\Property(
     *                      property="requests_per_category",
     *                      type="object",
     *                      @SWG\Property(
     *                          property="labels",
     *                          type="array",
     *                          items={"type"="string"},
     *                          example={"Disturbance", "Defect", "...."}
     *                      ),
     *                      @SWG\Property(
     *                          property="data",
     *                          type="array",
     *                          items={"type"="integer"},
     *                          example={"320", "425", "...."}
     *                      ),
     *                  ),
     *                  @SWG\Property(
     *                      property="total_tenants",
     *                      type="string",
     *                      example="200"
     *                  ),
     *                  @SWG\Property(
     *                      property="tenants_per_status",
     *                      ref="#/definitions/Donut"
     *                  ),
     *                  @SWG\Property(
     *                      property="total_buildings",
     *                      type="string",
     *                      example="200"
     *                  ),
     *                  @SWG\Property(
     *                      property="buildings_per_status",
     *                      ref="#/definitions/Donut"
     *                  ),
     *                  @SWG\Property(
     *                      property="total_products",
     *                      type="string",
     *                      example="200"
     *                  ),
     *                  @SWG\Property(
     *                      property="products_per_status",
     *                      ref="#/definitions/Donut"
     *                  ),
     *                  @SWG\Property(
     *                      property="total_posts",
     *                      type="string",
     *                      example="200"
     *                  ),
     *                  @SWG\Property(
     *                      property="posts_per_status",
     *                      ref="#/definitions/Donut"
     *                  ),
     *                  @SWG\Property(
     *                      property="all_start_dates",
     *                      type="object",
     *                      @SWG\Property(
     *                          property="requests",
     *                          type="string",
     *                          example="01.01.2019"
     *                      ),
     *                      @SWG\Property(
     *                          property="tenants",
     *                          type="string",
     *                          example="01.01.2019"
     *                      ),
     *                      @SWG\Property(
     *                          property="buildings",
     *                          type="string",
     *                          example="01.01.2019"
     *                      ),
     *                      @SWG\Property(
     *                          property="products",
     *                          type="string",
     *                          example="01.01.2019"
     *                      ),
     *                      @SWG\Property(
     *                          property="posts",
     *                          type="string",
     *                          example="01.01.2019"
     *                      ),
     *                  ),
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Request services statistics formatted successfully"
     *              )
     *          )
     *      )
     * )
     *
     * @param Request $request
     * @return mixed
     */
    public function adminStats(Request $request)
    {
        $optionalArgs = [
            'isConvertResponse' => false,
            'startDate' => null,
            'endDate' => null,
        ];

        $query = "select coalesce(floor(avg(time_to_sec(timediff(solved_date, created_at)))), 0) 
                                                      duration from service_requests where solved_date is not null;";
        $avgReqFix = DB::select($query);

        $allStartDates = [
            'requests' => $this->timeFormat(ServiceRequest::min('created_at')),
            'tenants' => $this->timeFormat(Tenant::min('created_at')),
            'buildings' => $this->timeFormat(Building::min('created_at')),
            'products' => $this->timeFormat(Product::min('created_at')),
            'posts' => $this->timeFormat(Post::min('created_at')),
        ];

        $ret = [
            'avg_request_duration' => $avgReqFix ? gmdate("H:i",$avgReqFix[0]->duration) : 0,
            // all time total requests count and total request count of per status
            'total_requests' => $this->thousandsFormat(ServiceRequest::count('id')),
            'requests_per_status' => $this->donutChartByTable($request, $optionalArgs, 'service_requests'),
            'requests_per_category' => $this->donutChartRequestByCategory($request, $optionalArgs),

            // all time total tenants count and total tenants count of per status
            'total_tenants' => $this->thousandsFormat(Tenant::count('id')),
            'tenants_per_status' => $this->donutChartByTable($request, $optionalArgs, 'tenants'),

            // all time total buildings count and total buildings count of per status
            'total_buildings' => $this->thousandsFormat(Building::count('id')),
            'buildings_per_status' => $this->allBuildingStatistics(),

            'total_products' => $this->thousandsFormat(Product::count('id')),
            'products_per_status' => $this->donutChartByTable($request, $optionalArgs, 'products'),

            'total_posts' => $this->thousandsFormat(Post::count('id')),
            'posts_per_status' => $this->donutChartByTable($request, $optionalArgs, 'posts'),
            'all_start_dates' => $allStartDates
        ];

        return $this->sendResponse($ret, 'Admin statistics retrieved successfully');
    }

    /**
     * @SWG\Get(
     *      path="/admin/chartRequestByCreationDate",
     *      summary="get statistics for Grouped Report for request",
     *      tags={"ServiceRequest", "CreationDate"},
     *      description="get statistics for Grouped Report for request",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          ref="#/parameters/period",
     *      ),
     *      @SWG\Parameter(
     *          ref="#/parameters/start_date",
     *      ),
     *      @SWG\Parameter(
     *          ref="#/parameters/end_date",
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
     *                  ref="#/definitions/StatisticByCreationDate"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Request services statistics formatted successfully"
     *              )
     *          )
     *      )
     * )
     *
     *
     * @param Request $request
     * @param array $optionalArgs
     * @return mixed
     */
    public function chartRequestByCreationDate(Request $request, $optionalArgs = [])
    {
        [$startDate, $endDate] = $this->getStartDateEndDate($request, $optionalArgs);
        $period = $this->getPeriod($request);
        [$periodValues, $raw] = $this->getPeriodRelatedData($period, $startDate, $endDate);

        $parentCategories = ServiceRequestCategory::whereNull('parent_id')->pluck('name', 'id')->toArray();
        $serviceRequests = ServiceRequest::selectRaw($raw . ', IF(cat2.id IS NULL, cat1.id, cat2.id) AS category_parent_id')
            ->join('service_request_categories AS cat1', 'service_requests.category_id', '=', 'cat1.id')
            ->leftJoin('service_request_categories AS cat2', 'cat1.parent_id', '=', 'cat2.id')
            ->whereDate('service_requests.created_at', '>=', $startDate->format('Y-m-d'))
            ->whereDate('service_requests.created_at', '<=', $endDate->format('Y-m-d'))
            ->groupBy('period')
            ->groupBy('category_parent_id')
            ->get();

        $ret = $this->formatResponseGropedPeriodAndCol($periodValues, $serviceRequests, 'category_parent_id', $parentCategories);
        $isConvertResponse = $optionalArgs['isConvertResponse'] ?? true;
        return $isConvertResponse
            ? $this->sendResponse($ret, 'Request services statistics formatted successfully')
            : $ret;
    }

    /**
     * @SWG\Get(
     *      path="/admin/chartByCreationDate",
     *      summary="get statistics for Grouped Report by products:status | tenants:status | posts:status ",
     *      tags={"Tenant", "Product", "Post", "CreationDate"},
     *      description="get statistics for Grouped Report by products:status | tenants:status | posts:status",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="table",
     *          in="query",
     *          description="The table used for get statistic data based db table",
     *          type="string",
     *          default="products",
     *          enum={"products", "tenants", "posts"}
     *      ),
     *      @SWG\Parameter(
     *          name="column",
     *          in="query",
     *          description="The column used for get statistic according that column",
     *          type="string",
     *          default="status",
     *          enum={"status"}
     *      ),
     *      @SWG\Parameter(
     *          ref="#/parameters/period",
     *      ),
     *      @SWG\Parameter(
     *          ref="#/parameters/start_date",
     *      ),
     *      @SWG\Parameter(
     *          ref="#/parameters/end_date",
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
     *                  ref="#/definitions/StatisticByCreationDate"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string",
     *                  example="products statistics formatted successfully by status"
     *              )
     *          )
     *      )
     * )
     *
     * @param Request $request
     * @param array $optionalArgs
     * @return mixed
     */
    public function chartByCreationDate(Request $request, $optionalArgs = [])
    {
        [$startDate, $endDate] = $this->getStartDateEndDate($request, $optionalArgs);
        [$class, $table, $column, $columnValues] = $this->getTableColumnClassByRequest(
            $request,
            self::PERMITTED_TABLES_FOR_CREATED_DATE,
            $optionalArgs
        );
        $period = $optionalArgs['period'] ?? $this->getPeriod($request);
        [$periodValues, $raw] = $this->getPeriodRelatedData($period, $startDate, $endDate, $table);

        $statistics = $class::selectRaw($raw . ',' . $column . ', count(id) `count`')
            ->whereDate('created_at', '>=', $startDate->format('Y-m-d'))
            ->whereDate('created_at', '<=', $endDate->format('Y-m-d'))
            ->groupBy('period')
            ->groupBy($column)
            ->get();

        $ret = $this->formatResponseGropedPeriodAndCol($periodValues, $statistics, $column, $columnValues);
        $isConvertResponse = $optionalArgs['isConvertResponse'] ?? true;
        return $isConvertResponse
            ? $this->sendResponse($ret, $table . ' statistics formatted successfully by ' . $column)
            : $ret;
    }

    /**
     * @SWG\Get(
     *      path="/admin/chartBuildingsByCreationDate",
     *      summary="get statistics for Grouped Report for buildings",
     *      tags={"Building", "CreationDate"},
     *      description="get statistics for Grouped Report for buildings",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          ref="#/parameters/period",
     *      ),
     *      @SWG\Parameter(
     *          ref="#/parameters/start_date",
     *      ),
     *      @SWG\Parameter(
     *          ref="#/parameters/end_date",
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
     *                  type="object",
     *                  @SWG\Property(
     *                      property="requests_per_day_xdata",
     *                      type="array",
     *                      items={"type"="string", "format"="full-date"},
     *                      example={"01.07.2019", "02.07.2019", ".......", "01.08.2019"}
     *                  ),
     *                  @SWG\Property(
     *                      property="requests_per_day_ydata",
     *                      type="array",
     *                      items={"type"="numeric"},
     *                      example={"4", "5", ".......", "2"}
     *                  ),
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Building statistics formatted successfully"
     *              )
     *          )
     *      )
     * )
     *
     *
     * @param Request $request
     * @param array $optionalArgs
     * @return mixed
     */
    public function chartBuildingsByCreationDate(Request $request, $optionalArgs = [])
    {
        [$startDate, $endDate] = $this->getStartDateEndDate($request, $optionalArgs);
        $period = $optionalArgs['period'] ?? $this->getPeriod($request);
        [$periodValues, $raw] = $this->getPeriodRelatedData($period, $startDate, $endDate, 'buildings');

        $statistics = Building::selectRaw($raw . ', count(id) `count`')
            ->whereDate('created_at', '>=', $startDate->format('Y-m-d'))
            ->whereDate('created_at', '<=', $endDate->format('Y-m-d'))
            ->groupBy('period')
            ->get();

        $raw = str_replace('building', 'unit', $raw);
        $units = Unit::selectRaw($raw . ', count(id) `count`')
            ->whereDate('created_at', '>=', $startDate->format('Y-m-d'))
            ->whereDate('created_at', '<=', $endDate->format('Y-m-d'))
            ->groupBy('period')
            ->get();


        $dayStatistic = [];
        foreach ($periodValues as $period => $__) {
            $dayStatistic[$period] = [
                'buildings' => 0,
                'units' => 0
            ];
        }

        foreach ($statistics as $statistic) {
            $dayStatistic[$statistic['period']]['buildings'] = $this->thousandsFormat($statistic['count']);
        }

        foreach ($units as $unit) {
            $dayStatistic[$unit['period']]['units'] = $this->thousandsFormat($unit['count']);
        }

        $response['requests_per_day_xdata'] = array_values($periodValues);
        $response['requests_per_day_ydata'] = array_values($dayStatistic);
        $isConvertResponse = $optionalArgs['isConvertResponse'] ?? true;
        return $isConvertResponse
            ? $this->sendResponse($response, 'Building statistics formatted successfully')
            : $response;
    }

    /**
     * @SWG\Get(
     *      path="/admin/donutChart",
     *      summary="service_requests, products, tenants,  posts statistics for Donut Chart",
     *      tags={"Tenant", "ServiceRequest", "Post", "Product", "Donut"},
     *      description="service_requests:status | tenants:status,title | products:status,type |  posts:status,type statistics for Donut Chart",
     *      produces={"application/json"},
     *     @SWG\Parameter(
     *          name="table",
     *          in="query",
     *          description="The table used for get statistic data based db table",
     *          type="string",
     *          default="service_requests",
     *          enum={"service_requests", "tenants", "products", "posts"}
     *      ),
     *      @SWG\Parameter(
     *          name="column",
     *          in="query",
     *          description="The column used for get statistic according that column | permitted values for each table [service_requests:status | tenants:status,title | products:status,type |  posts:status,type]",
     *          type="string",
     *          default="status",
     *          enum={"status", "type", "title"}
     *      ),
     *      @SWG\Parameter(
     *          name="start_date",
     *          in="query",
     *          description="format: dd.mm.yyyy | example: 19.06.2019 | Get statistic after correspond value. default value is one month ago of end_date",
     *          type="string",
     *          format="full-date"
     *      ),
     *      @SWG\Parameter(
     *          name="end_date",
     *          in="query",
     *          description="format: dd.mm.yyyy | example: 19.07.2019 | Get statistic before correspond value. | default value today",
     *          type="string",
     *          format="full-date"
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
     *                  ref="#/definitions/Donut"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string",
     *                  example="service_requests statistics by status retrieved successfully for DonutChart"
     *              )
     *          )
     *      )
     * )
     *
     *
     * @param Request $request
     * @param array $optionalArgs
     * @return mixed
     */
    public function donutChart(Request $request, $optionalArgs = [])
    {
        [$startDate, $endDate] = $this->getStartDateEndDate($request, $optionalArgs);
        [$class, $table, $column, $columnValues] = $this->getTableColumnClassByRequest(
            $request,
            self::PERMITTED_TABLES_GROUP,
            $optionalArgs
        );
        $statistics = $class::selectRaw($column . ', count(id) `count`')
            ->when($startDate, function ($q) use ($startDate) {$q->whereDate('created_at', '>=', $startDate->format('Y-m-d'));})
            ->when($endDate, function ($q) use ($endDate) {$q->whereDate('created_at', '<=', $endDate->format('Y-m-d'));})
            ->groupBy($column)
            ->orderBy($column)
            ->get();

        $includePercentage = ('service_requests' == $table) ? true : false;
        $response = $this->formatForDonutChart($statistics, $column, $columnValues, $includePercentage);

        $isConvertResponse = $optionalArgs['isConvertResponse'] ?? true;
        return $isConvertResponse
            ? $this->sendResponse($response, sprintf('%s statistics by %s retrieved successfully for DonutChart', $table, $column))
            : $response;
    }

    /**
     *
     * @SWG\Get(
     *      path="/admin/donutChartRequestByCategory",
     *      summary="Get request statistics for Donut Chart by service_request_categories",
     *      tags={"ServiceRequest", "Donut"},
     *      description="Get request statistics for Donut Chart by service_request_categories",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="start_date",
     *          in="query",
     *          description="format: dd.mm.yyyy | example: 19.06.2019 | Get statistic after correspond value. default value is one month ago of end_date",
     *          type="string",
     *          format="full-date"
     *      ),
     *      @SWG\Parameter(
     *          name="end_date",
     *          in="query",
     *          description="format: dd.mm.yyyy | example: 19.07.2019 | Get statistic before correspond value. | default value today",
     *          type="string",
     *          format="full-date"
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
     *                  type="object",
     *                  @SWG\Property(
     *                      property="labels",
     *                      description="Labels for statistics",
     *                      type="array",
     *                      items={"type"="string"},
     *                      example={"Disturbance", "Defect", "....."}
     *                  ),
     *                  @SWG\Property(
     *                      property="data",
     *                      description="data correspond labels",
     *                      type="array",
     *                      items={"type"="integer"},
     *                      example={"65", "130", "..."}
     *                  ),
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Request statistics retrieved successfully By service_request_categories"
     *              )
     *          )
     *      )
     * )
     *
     * @param Request $request
     * @param array $optionalArgs
     * @return mixed
     */
    public function donutChartRequestByCategory(Request $request, $optionalArgs = [])
    {
        [$startDate, $endDate] = $this->getStartDateEndDate($request, $optionalArgs);
        $parentCategories = ServiceRequestCategory::whereNull('parent_id')->pluck('name', 'id');
        $serviceRequests = ServiceRequest::selectRaw('count(service_requests.id) as count, IF(cat2.id IS NULL, cat1.id, cat2.id) AS category_parent_id')
            ->join('service_request_categories AS cat1', 'service_requests.category_id', '=', 'cat1.id')
            ->leftJoin('service_request_categories AS cat2', 'cat1.parent_id', '=', 'cat2.id')
            ->when($startDate, function ($q) use ($startDate) {$q->whereDate('service_requests.created_at', '>=', $startDate->format('Y-m-d'));})
            ->when($endDate, function ($q) use ($endDate) {$q->whereDate('service_requests.created_at', '<=', $endDate->format('Y-m-d'));})
            ->groupBy('category_parent_id')
            ->get();

        $statisticData = $parentCategories->values()->flip();
        foreach ($statisticData as $category => $__) {
            $statisticData[$category] = 0;
        }

        foreach ($serviceRequests as $serviceRequest) {
            $category = $parentCategories[$serviceRequest->category_parent_id];
            $statisticData[$category] = $this->thousandsFormat($serviceRequest->count);
        }

        $response = [
            'labels' => $statisticData->keys(),
            'data' => $statisticData->values()
        ];

        $isConvertResponse = $optionalArgs['isConvertResponse'] ?? true;
        return $isConvertResponse
            ? $this->sendResponse($response, 'Request statistics retrieved successfully By service_request_categories')
            : $response;
    }

    /**
     *
     * @SWG\Get(
     *      path="/admin/chartRequestByAssignedProvider",
     *      summary="Requests by service_providers statistics for donut chart",
     *      tags={"ServiceRequest", "Donut"},
     *      description="Requests by service_providers statistics for donut chart",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          ref="#/parameters/start_date",
     *      ),
     *      @SWG\Parameter(
     *          ref="#/parameters/end_date",
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
     *                  type="object",
     *                  @SWG\Property(
     *                      property="labels",
     *                      type="array",
     *                      items={"type"="string", "format"="full-date"},
     *                      example={"requests_with_service_providers", "request_wihout_service_providers"}
     *                  ),
     *                  @SWG\Property(
     *                      property="data",
     *                      type="array",
     *                      items={"type"="numeric"},
     *                      example={"45", "96"}
     *                  ),
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Requests by service_providers statistics retrieved successfully"
     *              )
     *          )
     *      )
     * )
     *
     * @param Request $request
     * @param array $optionalArgs
     * @return mixed
     */
    public function chartRequestByAssignedProvider(Request $request, $optionalArgs = [])
    {
        if (empty($optionalArgs) && empty($request->only(self::QUERY_PARAMS['start_date'], self::QUERY_PARAMS['end_date']))) {
            $startDate = null;
            $endDate = null;
        } else {
            [$startDate, $endDate] = $this->getStartDateEndDate($request, $optionalArgs);
        }

        $serviceRequestCount = ServiceRequest
            ::when($startDate, function ($q) use ($startDate) {$q->whereDate('service_requests.created_at', '>=', $startDate->format('Y-m-d'));})
            ->whereHas('category', function ($q) {
                $q->whereIn('id', [1, 2])->orWhereIn('parent_id', [1, 2]); // @TODO fix hard coding [1, 2]
            })
            ->when($endDate, function ($q) use ($endDate) {$q->whereDate('service_requests.created_at', '<=', $endDate->format('Y-m-d'));})
            ->count();

        $serviceRequestHasProviderCount = ServiceRequest
            ::has('providers')
            ->whereHas('category', function ($q) {
                $q->whereIn('id', [1, 2])->orWhereIn('parent_id', [1, 2]); // @TODO fix hard coding [1, 2]
            })
            ->when($startDate, function ($q) use ($startDate) {$q->whereDate('service_requests.created_at', '>=', $startDate->format('Y-m-d'));})
            ->when($endDate, function ($q) use ($endDate) {$q->whereDate('service_requests.created_at', '<=', $endDate->format('Y-m-d'));})
            ->count();

        $response = [
            'labels' => [
                'requests_with_service_providers',
                'request_wihout_service_providers'
            ],
            'data' => [
                $serviceRequestHasProviderCount,
                $serviceRequestCount - $serviceRequestHasProviderCount,
            ],
        ];

        return $this->sendResponse($response, 'Requests by service_providers statistics retrieved successfully');
    }

    /**

     * @SWG\Get(
     *      path="/admin/donutChartTenantsByDateAndStatus",
     *      summary="Tenants statistics for Donut Chart by service_requests status",
     *      tags={"Tenant", "Donut"},
     *      description="Tenants statistics for Donut Chart by service_requests status",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="start_date",
     *          in="query",
     *          description="format: dd.mm.yyyy | example: 19.06.2019 | Get statistic after correspond value. default value is one month ago of end_date",
     *          type="string",
     *          format="full-date"
     *      ),
     *      @SWG\Parameter(
     *          name="end_date",
     *          in="query",
     *          description="format: dd.mm.yyyy | example: 19.07.2019 | Get statistic before correspond value. | default value today",
     *          type="string",
     *          format="full-date"
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
     *                  type="object",
     *                  @SWG\Property(
     *                      property="labels",
     *                      description="Labels for statistics",
     *                      type="array",
     *                      items={"type"="string"},
     *                      example={"received", "in_processing", "....."}
     *                  ),
     *                  @SWG\Property(
     *                      property="ids",
     *                      description="key correspond labels",
     *                      type="array",
     *                      items={"type"="string"},
     *                      example={"1", "2", "..."}
     *                  ),
     *                  @SWG\Property(
     *                      property="data",
     *                      description="data correspond labels",
     *                      type="array",
     *                      items={"type"="integer"},
     *                      example={"65", "130", "..."}
     *                  ),
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Admin statistics retrieved successfully for tenants by request status"
     *              )
     *          )
     *      )
     * )
     *
     *
     * @param Request $request
     * @param array $optionalArgs
     * @return mixed
     */
    public function donutChartTenantsByDateAndStatus(Request $request, $optionalArgs = [])
    {
        [$startDate, $endDate] = $this->getStartDateEndDate($request, $optionalArgs);

        $rsPerStatus = Tenant::selectRaw('`service_requests`.`status`, count(`tenants`.`id`) `count`')
            ->join('service_requests', 'service_requests.tenant_id', 'tenants.id')
            ->whereDate('service_requests.created_at', '>=', $startDate->format('Y-m-d'))
            ->whereDate('service_requests.created_at', '<=', $endDate->format('Y-m-d'))
            ->groupBy('status')
            ->orderBy('status')
            ->get();

        $classStatus = ServiceRequest::Status;
        $response = $this->formatForDonutChart($rsPerStatus, 'status', $classStatus);

        $isConvertResponse = $optionalArgs['isConvertResponse'] ?? true;
        return $isConvertResponse
            ? $this->sendResponse($response, 'Admin statistics retrieved successfully for tenants by request status')
            : $response;
    }

    public function pieChartBuildingByState(Request $request, $optionalArgs = [])
    {
        [$startDate, $endDate] = $this->getStartDateEndDate($request, $optionalArgs);
        $statistics = Building::selectRaw('loc_states.id, count(buildings.id) `count`')
            ->join('loc_addresses', 'loc_addresses.id', '=', 'buildings.address_id')
            ->join('loc_states', 'loc_addresses.state_id', '=', 'loc_states.id')

            ->when($startDate, function ($q) use ($startDate) {$q->whereDate('buildings.created_at', '>=', $startDate->format('Y-m-d'));})
            ->when($endDate, function ($q) use ($endDate) {$q->whereDate('buildings.created_at', '<=', $endDate->format('Y-m-d'));})
            ->groupBy('loc_states.id')
            ->orderBy('loc_states.id')
            ->get();

        $stateIds = $statistics->pluck('id');
        $states = State::whereIn('id', $stateIds)->pluck('name', 'id')->all();
        $response = $this->formatForDonutChart($statistics, 'id', $states, true);

        $isConvertResponse = $optionalArgs['isConvertResponse'] ?? true;
        return $isConvertResponse
            ? $this->sendResponse($response, 'Building statistics by by state')
            : $response;
    }

        /**
     *
     * @SWG\Get(
     *      path="/admin/heatMapByDatePeriod",
     *      summary="Get Service Request statistics for Heat Map Graph",
     *      tags={"ServiceRequest", "HeatMap"},
     *      description="Get Service Request statistics for Heat Map Graph",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="period",
     *          in="query",
     *          description="The column used for get statistic for year period or week period",
     *          type="string",
     *          default="week",
     *          enum={"week", "year"}
     *      ),
     *      @SWG\Parameter(
     *          name="date",
     *          in="query",
     *          description="Format: dd.mm.yyyy | The column used for get statistic that date correspond week or year",
     *          type="string",
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  items={"type"="object"},
     *                  example={
     *                      {
     *                          "name" : 1,
     *                          "data": {
     *                               {
     *                                  "x": 1,
     *                                  "y": "6"
     *                              },
     *                              ".....",
     *                              {
     *                                  "x": 31,
     *                                  "y": "16"
     *                              },
     *                          }
     *                      },
     *                      ".........",
     *                      {
     *                          "name" : 12,
     *                          "data": {
     *                               {
     *                                  "x": 1,
     *                                  "y": "6"
     *                              },
     *                              ".....",
     *                              {
     *                                  "x": 31,
     *                                  "y": "16"
     *                              },
     *                          }
     *                      }
     *                  }
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Request services statistics formatted successfully for Heat Map"
     *              )
     *          )
     *      )
     * )
     *
     * @TODO improve
     * @param Request $request
     * @return mixed
     */
    public function heatMapByDatePeriod(Request $request)
    {
        $colStats = $this->getStatisticForHeatMap($request);
        $response = [];
        foreach ($colStats as $yAxis => $xAxisData) {
            $format = [];
            foreach ($xAxisData as $xAxis => $count) {
                $format[] = [
                    'x' => $xAxis,
                    'y' => $this->thousandsFormat($count)
                ];
            }

            $response[] = [
                'name' => $yAxis,
                'data' => $format
            ];
        }

        return $this->sendResponse($response, 'Request services statistics formatted successfully for Heat Map');
    }

    /**
     * @param $request
     * @return array
     */
    protected function getStatisticForHeatMap($request)
    {
        $date = $request->{self::QUERY_PARAMS['date']} ?? '';
        $date = Carbon::parse($date);
        $period =  $request->{self::QUERY_PARAMS['period']} ?? '';
        $period = in_array($period, self::PERMITTED_HEAT_PERIODS) ? $period : Arr::first(self::PERMITTED_HEAT_PERIODS);

        if (self::WEEK == $period) {
            $startDate = $date->subDays(($date->dayOfWeek - 1));
            $endDate = clone $startDate;
            $endDate = $endDate->addDays(6);
            $raw = "CONCAT(DATE(created_at), ' ',  HOUR(created_at))";
        } else {
//            mean self::YEAR == $period
            $startDate = $date;
            $startDate->setDay(1);
            $startDate->setMonth(1);
            $endDate = clone $startDate;
            $endDate->setDay(31);
            $endDate->setMonth(12);
            $raw = "CONCAT(DAY(created_at), ' ', MONTH(created_at))";
        }
        $statistics = ServiceRequest::selectRaw($raw . " AS `interval`, COUNT(id) AS `count`")
            ->whereDate('created_at', '>=', $startDate->format('Y-m-d'))
            ->whereDate('created_at', '<=', $endDate->format('Y-m-d'))
            ->groupBy('interval')->get();

        if (self::WEEK == $period) {
            return $this->getStatisticForHeatMapForWeek($statistics, $startDate, $endDate);
        }
        return $this->getStatisticForHeatMapForYear($statistics);
    }

    /**
     * @param $statistics
     * @param $startDate
     * @param $endDate
     * @return array
     */
    protected function getStatisticForHeatMapForWeek($statistics, $startDate, $endDate)
    {
        $hours = array_combine(range(1, 24), range(1, 24));
        $datePeriod = CarbonPeriod::create($startDate, $endDate);
        $intervalValues = [];

        foreach ($datePeriod as $date) {
            $intervalValues[$date->format('Y-m-d')] = $date->format('l');
        }
        $colStats = $this->initializeServiceRequestCategoriesForChart($intervalValues, $hours);

        foreach ($statistics as $statistic) {
            $parts = explode(' ', $statistic['interval']);
            $day = $parts[0];
            $y = $parts[1];
            $x = $intervalValues[$day];
            $colStats[$x][$y] = $this->thousandsFormat($statistic['count']);
        }

        return $colStats;
    }

    /**
     * @param $statistics
     * @return array
     */
    protected function getStatisticForHeatMapForYear($statistics)
    {
        $hours = array_combine(range(1, 12), range(1, 12));
        $intervalValues = array_combine(range(1, 31), range(1, 31));

        $colStats = $this->initializeServiceRequestCategoriesForChart($hours, array_flip($intervalValues));
        foreach ($statistics as $statistic) {
            $parts = explode(' ', $statistic['interval']);
            $day = $parts[0];
            $y = $parts[1];
            $x = $intervalValues[$day];
            $colStats[$y][$x] = $this->thousandsFormat($statistic['count']);
        }

        return $colStats;
    }


    /**
     *
     * @SWG\Get(
     *      path="/admin/chartLoginDevice",
     *      summary="Get statistics for Donut Chart by login device",
     *      tags={"Auth", "Donut"},
     *      description="Get all time statistics for Donut Chart by login device",
     *      produces={"application/json"},
     *
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
     *                  type="object",
     *                  @SWG\Property(
     *                      property="labels",
     *                      description="Labels for statistics",
     *                      type="array",
     *                      items={"type"="string"},
     *                      example={"Desktop", "Tablet", "Mobile"}
     *                  ),
     *                  @SWG\Property(
     *                      property="ids",
     *                      description="key correspond labels",
     *                      type="array",
     *                      items={"type"="string"},
     *                      example={"1", "2", "3"}
     *                  ),
     *                  @SWG\Property(
     *                      property="data",
     *                      description="data correspond labels",
     *                      type="array",
     *                      items={"type"="integer"},
     *                      example={"65", "130", "32"}
     *                  ),
     *                  @SWG\Property(
     *                      property="tag_percentage",
     *                      description="percentage correspond data",
     *                      type="array",
     *                      items={"type"="integer"},
     *                      example={"30", "60", "10"}
     *                  )
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Statistics by login device retrieved successfully"
     *              )
     *          )
     *      )
     * )
     *
     * @return mixed
     */
    protected function chartLoginDevice()
    {
        $loginDevices = LoginDevice::get(['mobile', 'desktop', 'tablet']);
        $mobileLoginCount = $loginDevices->where('mobile', 1)->count();
        $desktopLoginCount = $loginDevices->where('desktop', 1)->count();
        $tabletLoginCount = $loginDevices->where('tablet', 1)->count();

        $statistics = collect([
            [
                'login' => 1,
                'count' => $this->thousandsFormat($desktopLoginCount),
            ],
            [
                'login' => 2,
                'count' => $this->thousandsFormat($tabletLoginCount),
            ],
            [
                'login' => 3,
                'count' => $this->thousandsFormat($mobileLoginCount),
            ],
        ]);
        $values = [
            1 => 'Desktop',
            2 => 'Tablet',
            3 => 'Mobile',
        ];

        $response =  $this->formatForDonutChart($statistics, 'login', $values, true);
        return $this->sendResponse($response, 'Statistics by login device retrieved successfully');

    }

    /**
     *
     * @SWG\Get(
     *      path="/admin/chartTenantLanguage",
     *      summary="Tenants statistics for Donut Chart by language",
     *      tags={"Tenant", "Donut"},
     *      description="Tenants statistics for Donut Chart by language",
     *      produces={"application/json"},
     *
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
     *                  type="object",
     *                  @SWG\Property(
     *                      property="labels",
     *                      description="Labels for statistics",
     *                      type="array",
     *                      items={"type"="string"},
     *                      example={"Douche", "English", "....."}
     *                  ),
     *                  @SWG\Property(
     *                      property="ids",
     *                      description="key correspond labels",
     *                      type="array",
     *                      items={"type"="string"},
     *                      example={"de", "en", "..."}
     *                  ),
     *                  @SWG\Property(
     *                      property="data",
     *                      description="data correspond labels",
     *                      type="array",
     *                      items={"type"="integer"},
     *                      example={"65", "130", "..."}
     *                  ),
     *                  @SWG\Property(
     *                      property="tag_percentage",
     *                      description="percentage correspond data",
     *                      type="array",
     *                      items={"type"="integer"},
     *                      example={"30", "60", "..."}
     *                  )
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Tenants statistics by language retrieved successfully"
     *              )
     *          )
     *      )
     * )
     *
     * @return mixed
     */
    public function chartTenantLanguage()
    {
        $languages = config('app.locales');
//        $languages[null] = 'Unknown'; @TODO need or not

        $tenants = UserSettings::has('tenant')->selectRaw('count(id) as count, language')
            ->groupBy('language')
            ->get();

        $response = $this->formatForDonutChart($tenants, 'language', $languages, true);
        return $this->sendResponse($response, 'Tenants statistics by language retrieved successfully');
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
     * @param Request $request
     * @param $optionalArgs
     * @param string $table
     * @return mixed
     */
    protected function donutChartByTable(Request $request, $optionalArgs, $table = 'service_requests')
    {
        return $this->donutChart($request, array_merge($optionalArgs, ['table' => $table, 'column' => 'status']));
    }

    /**
     * @param $periodValues
     * @param $statistics
     * @param $column
     * @param $columnValues
     * @return mixed
     */
    protected function formatResponseGropedPeriodAndCol($periodValues, $statistics, $column, $columnValues)
    {
        $colStats = $this->initializeServiceRequestCategoriesForChart($columnValues, $periodValues);
        foreach ($statistics as $statistic) {
            $value = $columnValues[$statistic[$column]] ?? '';
            $colStats[$value][$statistic['period']] = $this->thousandsFormat($statistic['count']);
        }

        $formattedReqStatistics = [];
        foreach($colStats as $key => $value){
            $value = array_intersect_key($value, $periodValues);
            $formattedReqStatistics[] = [
                'name' => $key,
                'data' => array_values($value)
            ];
        }

        $ret['requests_per_day_xdata'] = array_values($periodValues);
        $ret['requests_per_day_ydata'] = $formattedReqStatistics;
        return $ret;
    }

    /**
     * @param $statistics
     * @param $column
     * @param $columnValues
     * @param bool $includePercentage
     * @return mixed
     */
    protected function formatForDonutChart($statistics, $column, $columnValues, $includePercentage = false)
    {
        $statistics = $statistics->whereIn($column, array_keys($columnValues));
        $existingStatuses = $statistics->pluck($column)->all();
        foreach ($columnValues as $value => $__) {
            if (! in_array($value, $existingStatuses)) {
                $stat[$column] = $value;
                $stat['count'] = 0;
                $statistics->push($stat);
            }
        }

        $response['labels'] = $statistics->map(function($el) use ($columnValues, $column) {
            return $columnValues[$el[$column]];
        });

        $response['ids'] = $statistics->map(function($el) use ($columnValues, $column) {
            return $el[$column];
        });

        $response['data'] = $statistics->map(function($el) {
            return $this->thousandsFormat($el['count']);
        });

        if ($includePercentage) {
            $sum = $response['data']->sum();
            $response['tag_percentage'] = $this->getTagPercentage($statistics, $sum);
        }

        return $response;
    }

    /**
     * @param $rsPerStatus
     * @param $sum
     * @return mixed
     */
    protected function getTagPercentage($rsPerStatus, $sum)
    {
        if (0 == $sum) {
            return 0;
        }

        $tagPercentages = $rsPerStatus->map(function($el) use ($sum) {
            return round($el['count']  * 100 / $sum);
        });

        $sumPercentage = $tagPercentages->sum();

        if ($sumPercentage != 100) {
            // @TODO improve this logic if need for make round max correct way
            $diff = $rsPerStatus->where('count', ">", 0)->map(function($el, $index) use ($sum, $tagPercentages) {
                return $el['count']  * 100 / $sum - $tagPercentages[$index];
            });
            $diff = $diff->sort();

            $difference = abs(100 - $sumPercentage);
            $sign = (100 - $sumPercentage > 0) ? 1 : -1;

            for ($i = 0; $i < $difference; $i++) {
                $key = $diff->keys()->last();
                $tagPercentages[$key] = $tagPercentages[$key] + $sign * 1;
                $diff->pop();
            }
        }

        return $tagPercentages;
    }

    /**
     * @param $parentCategories
     * @param $periodValues
     * @return array
     */
    protected function initializeServiceRequestCategoriesForChart($parentCategories, $periodValues)
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
     * @param $endDate
     * @param string $table
     * @return array
     */
    protected function getPeriodRelatedData($period, $startDate, $endDate, $table = 'service_requests')
    {
        $periodValues = [];

        if (self::YEAR == $period) {
            $part = "YEAR(" . $table . ".created_at)";
            $startDate->setMonth(1)->setDay(1);
            $endDate->setMonth(12)->setDay(31);
            $currentDate = clone $startDate;

            while ($currentDate < $endDate) {
                $periodValues[$currentDate->year] = $currentDate->year;
                $currentDate->addYear();
            }

        } elseif (self::MONTH == $period) {
            $part = "CONCAT(YEAR(" . $table . ".created_at), ' ', MONTH(" . $table . ".created_at))";
            $startDate->setDay(1);
            $endDate->addMonth()->setDay(1)->subDay();

            $currentDate = clone $startDate;
            while ($currentDate < $endDate) {
                $yearMonth = $currentDate->year . ' ' . $currentDate->month;
                $periodValues[$yearMonth] = $currentDate->format('M Y');
                $currentDate->addMonth();
            }
        } elseif (self::WEEK == $period) {

            if ($startDate->dayOfWeek) {
                $startDate = $startDate->subDays($startDate->dayOfWeek);
            }
            if (6 != $endDate->dayOfWeek) {
                $endDate = $endDate->addDays(6 - $endDate->dayOfWeek);
            }
            // @TODO check statistics when WEEK(created_at) = 1, 52, 53 maybe can income some incorrect data
            $part = "CONCAT(YEAR(" . $table . ".created_at), ' ', WEEK(" . $table . ".created_at))";
            $currentDate = clone $startDate;

            while ($currentDate < $endDate) {
                $yearWeek = $currentDate->year . ' ' . $currentDate->week;
                $periodValues[$yearWeek] = $currentDate->week . ' ' . $currentDate->year;
                $currentDate->addWeek();
            }

        } else {
            $part = "DATE(" . $table . ".created_at)";
            $datePeriod = CarbonPeriod::create($startDate, $endDate);
            foreach ($datePeriod as $date) {
                $periodValues[$date->format('Y-m-d')] = $date->format('d.m.Y');
            }
        }

        $raw = sprintf("count(" . $table . ".id) as count, %s as period", $part);


        return [$periodValues, $raw];
    }

    /**
     * @param $request
     * @param array $optionalArgs
     * @return array
     */
    protected function getStartDateEndDate($request, $optionalArgs = [])
    {
        if (key_exists('startDate', $optionalArgs) && key_exists('endDate', $optionalArgs)) {
            return [$optionalArgs['startDate'], $optionalArgs['endDate']];
        }

        $requestData = $request->all();
        $startDate = $requestData[self::QUERY_PARAMS['start_date']] ?? '';
        $endDate = $requestData[self::QUERY_PARAMS['end_date']] ?? '';

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
        $period = $request->{self::QUERY_PARAMS['period']} ?? self::DEFAULT_PERIOD;
        return in_array($period, self::PERMITTED_PERIODS) ? $period : self::DEFAULT_PERIOD;
    }

    /**
     * @TODO rename
     *
     * @param $request
     * @param $permissions
     * @param array $optionalArgs
     * @return array
     */
    protected function getTableColumnClassByRequest($request, $permissions, $optionalArgs = [])
    {
        $table = $optionalArgs['table'] ?? null;
        $table = $table ?? $request->{self::QUERY_PARAMS['table']};
        $table = key_exists($table, $permissions) ? $table : Arr::first(array_keys($permissions));
        $class = $permissions[$table]['class'];

        $permittedColumns = [];
        foreach ($permissions[$table]['columns'] as $column => $columnValues) {
            if (is_numeric($column)) {
                $column = $columnValues;
                $columnValues = constant($class . "::" . ucfirst($column));
            }
            $permittedColumns[$column] = $columnValues;
        }

        $_permittedColumns = array_keys($permittedColumns);
        $column = $optionalArgs['column'] ?? null;
        $column = $column ?? $request->{self::QUERY_PARAMS['column']};
        $column = in_array($column, $_permittedColumns) ? $column : Arr::first($_permittedColumns);
        $columnValues = $permittedColumns[$column];

        return [$class, $table, $column, $columnValues];
    }

    /**
     * @param $number
     * @return string
     */
    protected function thousandsFormat($number)
    {
        if (! is_numeric($number)) {
            return $number;
        }

        return number_format($number, 0, ".", "'");
    }

    /**
     * @param $date
     * @return string
     */
    protected function timeFormat($date)
    {
        return Carbon::parse($date)->format('d.m.Y');
    }
}
