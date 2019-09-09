<?php

namespace App\Criteria\ServiceProviders;

use App\Models\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FilterByBuildingCriteria
 * @package App\Criteria\ServiceProviders
 */
class FilterByRelationsCriteria implements CriteriaInterface
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
        $quarterId = $this->request->get('quarter_id', null);
        $categoryId = $this->request->get('category_id', null);

        if (empty($quarterId) && empty($buildingId) && empty($categoryId)) {
            return $model;
        }

        $type = get_morph_type_of(ServiceProvider::class);
        $model->join('request_assignees as ra', 'ra.assignee_id', '=', 'service_providers.id')
            ->join('service_requests as sr', 'sr.id', '=', 'ra.request_id')
            ->join('tenants', 'tenants.id', '=', 'sr.tenant_id')
            ->join('buildings', 'tenants.building_id', '=', 'buildings.id')
            ->where('ra.assignee_type', $type)
            ->when($buildingId, function ($q) use ($buildingId) {
                $q->where('buildings.id', $buildingId);
            })->when($quarterId, function ($q) use ($quarterId) {
                $q->where('buildings.quarter_id', $quarterId);
            })->when($quarterId, function ($q) use ($categoryId) {
                $q->where('sr.category_id', $categoryId);
            });

        return $model;
    }
}
