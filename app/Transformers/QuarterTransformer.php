<?php

namespace App\Transformers;

use App\Models\Quarter;

/**
 * Class QuarterTransformer.
 *
 * @package namespace App\Transformers;
 */
class QuarterTransformer extends BaseTransformer
{
    /**
     * @param Quarter $model
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function transform(Quarter $model)
    {
        $response = [
            'id' => $model->id,
            'name' => $model->name,
            'quarter_format' => $model->quarter_format,
            'description' => $model->description,
            'count_of_buildings' => $model->count_of_buildings,
        ];

        if ($model->relationExists('address')) {
            $response['address'] = (new AddressTransformer)->transform($model->address);
        }

        return $response;
    }

    /**
     * @param Quarter $model
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function transformWIthStatistics(Quarter $model)
    {
        $response = $this->transform($model);
        $buildings = $model->buildings;
        $units = $buildings->pluck('units')->collapse();
        $occupiedUnits = $units->filter(function ($unit) {
            return $unit->rent_contracts->isNotEmpty();
        });

        $counts['buildings'] = $buildings->count();
        $counts['active_tenants'] = $units->pluck('rent_contracts.*.tenant_id')->collapse()->unique()->count();
        $counts['units'] = [
            'total' => $units->count(),
            'occupied' => $occupiedUnits->count(),
            'free' => $units->count() - $occupiedUnits->count(),
        ];
        $response['counts'] = $counts;
        return $response;
    }
}
