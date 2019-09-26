<?php

namespace App\Criteria\Common;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Criteria\RequestCriteria as ReqCriteria;

/**
 * Class FilterByRelatedFieldsCriteria
 * @package Prettus\Repository\Criteria
 */
class RequestCriteria extends ReqCriteria
{
    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $orderByDefault = 'id';
        $model = $request->get('model');
        if ($model) {
            $orderByDefault = sprintf('%s.%s', $model, $orderByDefault);
        }

        $orderBy = $request->get('orderBy', $orderByDefault);
        $sortedBy = $request->get('sortedBy', 'desc');
        $request->merge([
            'orderBy' => $orderBy,
            'sortedBy' => $sortedBy
        ]);

        parent::__construct($request);
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
        $ids = $this->request->get('exclude_ids', null);
        if ($ids) {
            if (!is_array($ids)) {
                $ids = explode(',', $ids);
            }
            $model = $model->whereNotIn($model->qualifyColumn('id'), $ids);
        }

        return parent::apply($model, $repository);
    }
}
