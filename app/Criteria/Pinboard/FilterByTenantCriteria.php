<?php

namespace App\Criteria\Pinboard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FilterByTenantCriteria
 * @package Prettus\Repository\Criteria
 */
class FilterByTenantCriteria implements CriteriaInterface
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
     * @param Model $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     * @throws \Exception
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $tenant_id = $this->request->get('tenant_id', null);

        $createdByTenant = $this->request->get('createdby_tenant', false);
        if ($createdByTenant) {
            $model = $model->whereHas('user', function ($q) {
                $q->has('tenant');
            });
        }

        if (!$tenant_id) {
            return $model;
        }
        // @TODO discuss
        $model = $model->where('id', $tenant_id);
        return $model;
    }
}
