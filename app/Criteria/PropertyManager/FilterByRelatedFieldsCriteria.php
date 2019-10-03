<?php

namespace App\Criteria\PropertyManager;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FilterByRelatedFieldsCriteria
 * @package Prettus\Repository\Criteria
 */
class FilterByRelatedFieldsCriteria implements CriteriaInterface
{
    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply criteria in query repository
     *
     * @param Builder|Model $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     * @throws \Exception
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $buildingId = $this->request->get('building_id', null);
        if ($buildingId) {
            $model->whereHas('buildings', function ($q) use ($buildingId) {
                $q->where('buildings.id', $buildingId);
            });
        }

        $quarterId = $this->request->get('quarter_id', null);
        if ($quarterId) {
            $model->whereHas('buildings', function ($q) use ($quarterId) {
                $q->where('buildings.quarter_id', $quarterId);
            });
        }

        return $model;
    }
}
