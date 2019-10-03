<?php

namespace App\Criteria\Request;

use App\Models\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FilterPublicCriteria
 * @package Prettus\Repository\Criteria
 */
class FilterPublicCriteria implements CriteriaInterface
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * FilterPublicCriteria constructor.
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(\Illuminate\Http\Request $request)
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
        if (!$this->request->get('is_public', null)) {
            return $model;
        }

        $vs = [
            Request::VisibilityBuilding,
            Request::VisibilityQuarter,
        ];
        return $model->whereIn('requests.visibility', $vs);
    }
}
