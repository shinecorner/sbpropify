<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Repositories\AuditRepository;
use App\Transformers\AuditTransformer;
use Prettus\Repository\Criteria\RequestCriteria;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use App\Criteria\Audit\FilterByUserCriteria;
use App\Criteria\Audit\FilterByAuditableCriteria;
use App\Criteria\Audit\FilterByEventCriteria;
use App\Http\Requests\API\Audit\ListRequest;

/**
 * Class AuditController
 * @package App\Http\Controllers\API
 */

class AuditAPIController extends AppBaseController
{
    /** @var  AuditRepository */
    private $auditRepository;

    /**
     * @var AuditTransformer
     */
    private $auditTransformer;

    /**
     * AuditAPIController constructor.
     * @param AuditRepository $ar
     * @param AuditTransformer $at
     */
    public function __construct(AuditRepository $ar, AuditTransformer $at)
    {
        $this->auditRepository = $ar;
        $this->auditTransformer = $at;
    }

    /**
     * @SWG\Get(
     *      path="/audits",
     *      summary="Get a listing of the Audits.",
     *      tags={"Audit"},
     *      description="Get all Audits",
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
     *                  type="object"
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
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function index(ListRequest $request)
    {
        $this->auditRepository->pushCriteria(new RequestCriteria($request));
        $this->auditRepository->pushCriteria(new LimitOffsetCriteria($request));
        $this->auditRepository->pushCriteria(new FilterByUserCriteria($request));
        $this->auditRepository->pushCriteria(new FilterByAuditableCriteria($request));
        $this->auditRepository->pushCriteria(new FilterByEventCriteria($request));

        $perPage = $request->get('per_page', env('APP_PAGINATE', 10));
        $audits = $this->auditRepository->with(['user'])->paginate($perPage);

        $out = $this->auditTransformer->transformPaginator($audits);
        return $this->sendResponse($out, 'Audits retrieved successfully');
    }
}
