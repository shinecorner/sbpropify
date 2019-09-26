<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\Translation\CreateRequest;
use App\Http\Requests\API\Translation\DeleteRequest;
use App\Http\Requests\API\Translation\ListRequest;
use App\Http\Requests\API\Translation\UpdateRequest;
use App\Http\Requests\API\Translation\ViewRequest;
use App\Models\Translation;
use App\Repositories\TranslationRepository;
use Illuminate\Http\Request;
use Response;

/**
 * Class TranslationController
 * @package App\Http\Controllers\API
 */
class TranslationAPIController extends AppBaseController
{
    /** @var  TranslationRepository */
    private $translationRepository;

    /**
     * TranslationAPIController constructor.
     * @param TranslationRepository $translationRepo
     */
    public function __construct(TranslationRepository $translationRepo)
    {
        $this->translationRepository = $translationRepo;
    }

    /**
     * @SWG\Get(
     *      path="/translations",
     *      summary="Get a listing of the Translations.",
     *      tags={"Translation"},
     *      description="Get all Translations",
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
     *                  @SWG\Items(ref="#/definitions/Translation")
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
     */
    public function index(ListRequest $request)
    {
        $translations = $this->translationRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($translations->toArray(), 'Translations retrieved successfully');
    }

    /**
     * @SWG\Post(
     *      path="/translations",
     *      summary="Store a newly created Translation in storage",
     *      tags={"Translation"},
     *      description="Store Translation",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Translation that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Translation")
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
     *                  ref="#/definitions/Translation"
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

        $translations = $this->translationRepository->create($input);

        return $this->sendResponse($translations->toArray(), 'Translation saved successfully');
    }

    /**
     * @SWG\Get(
     *      path="/translations/{id}",
     *      summary="Display the specified Translation",
     *      tags={"Translation"},
     *      description="Get Translation",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Translation",
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
     *                  ref="#/definitions/Translation"
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
        /** @var Translation $translation */
        $translation = $this->translationRepository->find($id);

        if (empty($translation)) {
            return $this->sendError('Translation not found');
        }

        return $this->sendResponse($translation->toArray(), 'Translation retrieved successfully');
    }

    /**
     * @SWG\Put(
     *      path="/translations/{id}",
     *      summary="Update the specified Translation in storage",
     *      tags={"Translation"},
     *      description="Update Translation",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Translation",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Translation that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Translation")
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
     *                  ref="#/definitions/Translation"
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

        /** @var Translation $translation */
        $translation = $this->translationRepository->find($id);

        if (empty($translation)) {
            return $this->sendError('Translation not found');
        }

        $translation = $this->translationRepository->update($input, $id);

        return $this->sendResponse($translation->toArray(), 'Translation updated successfully');
    }

    /**
     * @SWG\Delete(
     *      path="/translations/{id}",
     *      summary="Remove the specified Translation from storage",
     *      tags={"Translation"},
     *      description="Delete Translation",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Translation",
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
     * @param DeleteRequest $deleteRequest
     * @return mixed
     * @throws \Exception
     */
    public function destroy($id, DeleteRequest $deleteRequest)
    {
        /** @var Translation $translation */
        $translation = $this->translationRepository->find($id);

        if (empty($translation)) {
            return $this->sendError('Translation not found');
        }

        $translation->delete();

        return $this->sendResponse($id, 'Translation deleted successfully');
    }
}
