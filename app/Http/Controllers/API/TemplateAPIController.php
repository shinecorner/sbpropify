<?php

namespace App\Http\Controllers\API;

use App\Criteria\Common\RequestCriteria;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\Template\CreateRequest;
use App\Http\Requests\API\Template\DeleteRequest;
use App\Http\Requests\API\Template\ListCategoriesRequest;
use App\Http\Requests\API\Template\ListRequest;
use App\Http\Requests\API\Template\UpdateRequest;
use App\Http\Requests\API\Template\ViewRequest;
use App\Models\Template;
use App\Repositories\TemplateCategoryRepository;
use App\Repositories\TemplateRepository;
use App\Transformers\TemplateCategoryTransformer;
use App\Transformers\TemplateTransformer;
use Exception;
use Illuminate\Http\Response;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;

/**
 * Class TemplateController
 * @package App\Http\Controllers\API
 */
class TemplateAPIController extends AppBaseController
{
    /** @var  TemplateRepository */
    private $templateRepository;

    /** @var  TemplateCategoryRepository */
    private $templateCategoryRepository;

    /**
     * TemplateAPIController constructor.
     * @param TemplateRepository $templateRepo
     * @param TemplateCategoryRepository $templateCategoryRepo
     */
    public function __construct(TemplateRepository $templateRepo, TemplateCategoryRepository $templateCategoryRepo)
    {
        $this->templateRepository = $templateRepo;
        $this->templateCategoryRepository = $templateCategoryRepo;
    }

    /**
     * @SWG\Get(
     *      path="/templates",
     *      summary="Get a listing of the Templates.",
     *      tags={"Template"},
     *      description="Get all Templates",
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
     *                  @SWG\Items(ref="#/definitions/Template")
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
     * @return Response
     * @throws Exception
     */
    public function index(ListRequest $request)
    {
        $this->templateRepository->pushCriteria(new RequestCriteria($request));
        $this->templateRepository->pushCriteria(new LimitOffsetCriteria($request));

        $getAll = $request->get('get_all', false);
        if ($getAll) {
            $request->merge(['limit' => env('APP_PAGINATE', 10)]);
            $this->templateRepository->pushCriteria(new LimitOffsetCriteria($request));
            $templates = $this->templateRepository->get();
            return $this->sendResponse($templates->toArray(), 'Templates retrieved successfully');
        }

        $perPage = $request->get('per_page', env('APP_PAGINATE', 10));
        $templates = $this->templateRepository->with(['category'])->paginate($perPage);

        $response = (new TemplateTransformer)->transformPaginator($templates);
        return $this->sendResponse($response, 'Templates retrieved successfully');
    }

    /**
     * @SWG\Get(
     *      path="/templates/categories",
     *      summary="Get a listing of the Templates.",
     *      tags={"TemplateCategory"},
     *      description="Get all TemplateCategories",
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
     *                  @SWG\Items(ref="#/definitions/TemplateCategory")
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
     * @return Response
     * @throws Exception
     */
    public function categories(ListRequest $request)
    {
        $templateCategories = $this->templateCategoryRepository->findWhere([
            'parent_id' => null
        ]);

        $response = (new TemplateCategoryTransformer)->transformCollection($templateCategories);
        return $this->sendResponse($response, 'Templates Categories retrieved successfully');
    }

    /**
     * @SWG\Post(
     *      path="/templates",
     *      summary="Store a newly created Template in storage",
     *      tags={"Template"},
     *      description="Store Template",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Template that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Template")
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
     *                  ref="#/definitions/Template"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     *
     * @param CreateRequest $request
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CreateRequest $request)
    {
        $input = $request->all();
        $template = $this->templateRepository->create($input);

        $template->load('translations');
        $response = (new TemplateTransformer)->transform($template);
        return $this->sendResponse($response, __('models.template.saved'));
    }

    /**
     * @SWG\Get(
     *      path="/templates/{id}",
     *      summary="Display the specified Template",
     *      tags={"Template"},
     *      description="Get Template",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Template",
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
     *                  ref="#/definitions/Template"
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
     * @param ViewRequest $r
     * @return mixed
     */
    public function show($id, ViewRequest $r)
    {
        /** @var Template $template */
        $template = $this->templateRepository->with(['category'])->find($id);
        if (empty($template)) {
            return $this->sendError(__('models.template.errors.not_found'));
        }

        $template->load('translations');
        $response = (new TemplateTransformer)->transform($template);
        return $this->sendResponse($response, 'Template retrieved successfully');
    }

    /**
     * @SWG\Put(
     *      path="/templates/{id}",
     *      summary="Update the specified Template in storage",
     *      tags={"Template"},
     *      description="Update Template",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Template",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Template that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Template")
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
     *                  ref="#/definitions/Template"
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
     * @param UpdateRequest $request
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update($id, UpdateRequest $request)
    {
        $input = $request->all();

        /** @var Template $template */
        $template = $this->templateRepository->find($id);

        if (empty($template)) {
            return $this->sendError(__('models.template.errors.not_found'));
        }

        $template = $this->templateRepository->update($input, $id);

        $template->load('translations');
        $response = (new TemplateTransformer)->transform($template);
        return $this->sendResponse($response, __('models.template.saved'));
    }

    /**
     * @SWG\Delete(
     *      path="/templates/{id}",
     *      summary="Remove the specified Template from storage",
     *      tags={"Template"},
     *      description="Delete Template",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Template",
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
     *
     * @param $id
     * @param DeleteRequest $r
     * @return mixed
     * @throws Exception
     */
    public function destroy($id, DeleteRequest $r)
    {
        /** @var Template $template */
        $template = $this->templateRepository->find($id);

        if (empty($template)) {
            return $this->sendError(__('models.template.errors.not_found'));
        }

        $template->delete();

        return $this->sendResponse($id, __('models.template.deleted'));
    }
}
