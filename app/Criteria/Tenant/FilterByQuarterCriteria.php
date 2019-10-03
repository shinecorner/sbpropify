<?php

namespace App\Criteria\Tenant;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FilterByQuarterCriteria
 * @package Prettus\Repository\Criteria
 */
class FilterByQuarterCriteria implements CriteriaInterface
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
        $did = $this->request->get('quarter_id', null);
        if ($did) {
            $model->join('buildings', 'buildings.id', '=', 'tenants.building_id')
                ->where('buildings.quarter_id', $did);
        }

        return $model;
    }
}
