<?php

namespace App\Criteria\ServiceRequests;

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
        $categoryId = $this->request->get('category_id', null);
        if ($categoryId) {
            $model->where('category_id', $categoryId);
        }

        $tenantId = $this->request->get('tenant_id', null);
        if ($tenantId) {
            $model->where('tenant_id', $tenantId);
        }

        $unitId = $this->request->get('unit_id', null);
        if ($unitId) {
            $model->where('unit_id', $unitId);
//            $model->whereHas('category', function ($q) {
//                $q->where('name', 'apartment');
//            });
        }

        $providerId = $this->request->get('service_provider_id', null) ?? $this->request->get('service_id', null);

        if ($providerId) {
            $model->whereHas('providers', function ($q) use ($providerId) {
                $q->where('assignee_id', $providerId);
            });
        }

        // @TODO need filter to property manager or user also rename
        $managerId = $this->request->get('property_manager_id', null) ?? $this->request->get('assignee_id', null);

        if ($managerId) {
            $model->whereHas('managers', function ($q) use ($managerId) {
                $q->where('assignee_id', $managerId);
            });
        }

        $buildingId = $this->request->get('building_id', null);
        if ($buildingId) {
            $model->whereHas('tenant', function ($query) use ($buildingId) {
                $query->where('building_id', $buildingId);
            });
        }

        $quarterId = $this->request->get('quarter_id', null) ?? $this->request->get('district_id', null);
        if ($quarterId) {
            $model->whereHas('tenant.building', function ($query) use ($quarterId) {
                $query->where('quarter_id', $quarterId);
            });
        }

        return $model;
    }
}
