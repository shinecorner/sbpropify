<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Repositories\CountryRepository;
use App\Transformers\CountryTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * Class CountryController
 * @package App\Http\Controllers\API
 */

class CountryAPIController extends AppBaseController
{
    /** @var  CountryRepository */
    private $countryRepository;

    /**
     * CountryAPIController constructor.
     * @param CountryRepository $countryRepo
     */
    public function __construct(CountryRepository $countryRepo)
    {
        $this->countryRepository = $countryRepo;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws RepositoryException
     *
     * @SWG\Get(
     *      path="/countrys",
     *      summary="Get a listing of the Countrys.",
     *      tags={"Location"},
     *      description="Get all Countrys",
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
     *                  @SWG\Items(ref="#/definitions/Country")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $this->countryRepository->pushCriteria(new RequestCriteria($request));
        $this->countryRepository->pushCriteria(new LimitOffsetCriteria($request));

        $countries = $this->countryRepository->get();

        $response = (new CountryTransformer)->transformCollection($countries);
        return $this->sendResponse($response, 'Countries retrieved successfully');
    }
}
