<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\Quarter\CreateRequest;
use App\Http\Requests\API\Quarter\UpdateRequest;
use App\Http\Requests\API\Quarter\ListRequest;
use App\Http\Requests\API\Quarter\ViewRequest;
use App\Http\Requests\API\Quarter\DeleteRequest;
use App\Models\Quarter;
use App\Repositories\QuarterRepository;
use App\Transformers\QuarterTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use App\Criteria\Common\RequestCriteria;

/**
 * Class QuarterController
 * @package App\Http\Controllers\API
 */
class QuarterAPIController extends AppBaseController
{
    /** @var  QuarterRepository */
    private $quarterRepository;

    public function __construct(QuarterRepository $quarterRepo)
    {
        $this->quarterRepository = $quarterRepo;
    }

    /**
     * @param ListRequest $request
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @SWG\Get(
     *      path="/quarters",
     *      summary="Get a listing of the Quarters.",
     *      tags={"Quarter"},
     *      description="Get all Quarters",
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
     *                  @SWG\Items(ref="#/definitions/Quarter")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(ListRequest $request)
    {
        $this->quarterRepository->pushCriteria(new RequestCriteria($request));
        $this->quarterRepository->pushCriteria(new LimitOffsetCriteria($request));

        $getAll = $request->get('get_all', false);
        if ($getAll) {
            $quarters = $this->quarterRepository->get();
            $response = (new QuarterTransformer)->transformCollection($quarters);
            return $this->sendResponse($response, 'Quarters retrieved successfully');
        }

        $perPage = $request->get('per_page', env('APP_PAGINATE', 10));
        $quarters = $this->quarterRepository->paginate($perPage);

        $response = (new QuarterTransformer)->transformPaginator($quarters);
        return $this->sendResponse($response, 'Quarters retrieved successfully');
    }

    /**
     * @param CreateRequest $request
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     *
     * @SWG\Post(
     *      path="/quarters",
     *      summary="Store a newly created Quarter in storage",
     *      tags={"Quarter"},
     *      description="Store Quarter",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Quarter that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Quarter")
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
     *                  ref="#/definitions/Quarter"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateRequest $request)
    {
        $input = $request->all();
        $quarter = $this->quarterRepository->create($input);
        $response = (new QuarterTransformer)->transform($quarter);

        return $this->sendResponse($response, __('models.quarter.saved'));
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/quarters/{id}",
     *      summary="Display the specified Quarter",
     *      tags={"Quarter"},
     *      description="Get Quarter",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Quarter",
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
     *                  ref="#/definitions/Quarter"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id, ViewRequest $r)
    {
        /** @var Quarter $quarter */
        $quarter = $this->quarterRepository->findWithoutFail($id);
        if (empty($quarter)) {
            return $this->sendError(__('models.quarter.errors.not_found'));
        }

        $response = (new QuarterTransformer)->transform($quarter);

        return $this->sendResponse($response, 'Quarter retrieved successfully');
    }

    /**
     * @param $id
     * @param UpdateRequest $request
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     *
     * @SWG\Put(
     *      path="/quarters/{id}",
     *      summary="Update the specified Quarter in storage",
     *      tags={"Quarter"},
     *      description="Update Quarter",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Quarter",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Quarter that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Quarter")
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
     *                  ref="#/definitions/Quarter"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateRequest $request)
    {
        $input = $request->all();

        /** @var Quarter $quarter */
        $quarter = $this->quarterRepository->findWithoutFail($id);

        if (empty($quarter)) {
            return $this->sendError(__('models.quarter.errors.not_found'));
        }

        $quarter = $this->quarterRepository->updateExisting($quarter, $input);

        $response = (new QuarterTransformer)->transform($quarter);
        return $this->sendResponse($response, __('models.quarter.saved'));
    }

    /**
     * @param $id
     * @param DeleteRequest $r
     * @return mixed
     * @throws \Exception
     *
     *
     * @SWG\Delete(
     *      path="/quarters/{id}",
     *      summary="Remove the specified Quarter from storage",
     *      tags={"Quarter"},
     *      description="Delete Quarter",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Quarter",
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
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id, DeleteRequest $r)
    {
        /** @var Quarter $quarter */
        $quarter = $this->quarterRepository->findWithoutFail($id);

        if (empty($quarter)) {
            return $this->sendError(__('models.quarter.errors.not_found'));
        }

        $quarter->delete();

        return $this->sendResponse($id, __('models.quarter.deleted'));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function destroyWithIds(Request $request){
        $ids = $request->get('ids');
        try{
            Quarter::destroy($ids);
        }
        catch (\Exception $e) {
            return $this->sendError(__('models.quarter.errors.deleted') . $e->getMessage());
        }
        return $this->sendResponse($ids, __('models.quarter.deleted'));
    }
}
