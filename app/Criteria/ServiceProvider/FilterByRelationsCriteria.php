<?php

namespace App\Criteria\ServiceProvider;

use App\Models\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FilterByBuildingCriteria
 * @package App\Criteria\ServiceProvider
 */
class FilterByRelationsCriteria implements CriteriaInterface
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * FilterByRelationsCriteria constructor.
     * @param Request $request
     */
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

        if (empty($quarterId) && empty($buildingId)) {
            return $model;
        }

        $type = get_morph_type_of(ServiceProvider::class);
        $model->join('request_assignees as ra', 'ra.assignee_id', '=', 'service_providers.id')
            ->join('requests as r', 'r.id', '=', 'ra.request_id')
            ->join('tenants', 'tenants.id', '=', 'r.tenant_id')
            ->join('buildings', 'tenants.building_id', '=', 'buildings.id')
            ->where('ra.assignee_type', $type)
            ->when($buildingId, function ($q) use ($buildingId) {
                $q->where('buildings.id', $buildingId);
            })->when($quarterId, function ($q) use ($quarterId) {
                $q->where('buildings.quarter_id', $quarterId);
            });

        return $model;
    }
}
