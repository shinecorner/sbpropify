<?php

namespace App\Criteria\PropertyManagers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FilterByPostCriteria
 * @package Prettus\Repository\Criteria
 */
class HasRequestCriteria implements CriteriaInterface
{


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
        $model = $model->whereHas('user', function ($q) {
            $q->has('requests');
        });
        return $model;
    }
}
