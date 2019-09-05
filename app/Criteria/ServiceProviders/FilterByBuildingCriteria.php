<?php

namespace App\Criteria\ServiceProviders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FilterByBuildingCriteria
 * @package App\Criteria\ServiceProviders
 */
class FilterByBuildingCriteria implements CriteriaInterface
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    /**
     * Apply criteria in query repository
     *
     * @param         Builder|Model     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     * @throws \Exception
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $buildingId = $this->request->get('building_id', null);
        if (!$buildingId) { return $model; }

        $model->join('building_service_provider', 'building_service_provider.service_provider_id', '=', 'service_providers.id')
            ->where('building_service_provider.building_id', $buildingId);

        return $model;
    }
}
