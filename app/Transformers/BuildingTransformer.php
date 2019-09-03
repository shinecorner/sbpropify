<?php

namespace App\Transformers;

use App\Models\Building;

/**
 * Class BuildingTransformer.
 *
 * @package namespace App\Transformers;
 */
class BuildingTransformer extends BaseTransformer
{
    protected $defaultIncludes = [
        'address'
    ];

    /**
     * Transform the Building entity.
     *
     * @param \App\Models\Building $model
     *
     * @return array
     */
    public function transform(Building $model)
    {
        $response = [
            'id' => $model->id,
            'name' => $model->name,
            'building_format' => $model->building_format,
            'label' => $model->label,
            'contact_enable' => $model->contact_enable,
            'description' => $model->description,
            'floor_nr' => $model->floor_nr,
            'basement' => $model->basement,
            'attic' => $model->attic,
            'created_at' => $model->created_at->format('Y-m-d'),
            'quarter_id' => $model->quarter_id,
            'district_id' => $model->quarter_id,

            'units_count' => $model->units_count,
            'tenants_count' => 0,
            'active_tenants_count' => 0,
            'in_active_tenants_count' => 0,
            'property_managers_count' => 0
        ];

        $withCount = $model->getStatusRelationCounts();
        $response = array_merge($response, $withCount);


        if ($model->relationExists('address')) {
            $response['address'] = (new AddressTransformer)->transform($model->address);
        }

        if ($model->relationExists('quarter')) {
            $response['quarter'] = (new QuarterTransformer)->transform($model->quarter);
            $response['district'] = $response['quarter'];
        }

        if(! is_null($model->getAttribute('active_tenants_count'))) {
            $response['active_tenants_count'] = $model->getAttribute('active_tenants_count');
        }

        if(! is_null($model->getAttribute('in_active_tenants_count'))) {
            $response['in_active_tenants_count'] = $model->getAttribute('in_active_tenants_count');
        }

        if ($model->relationExists('tenants')) {
            $response['tenants'] = (new TenantSimpleTransformer)->transformCollection($model->tenants);
            $response['tenants_last'] = (new TenantSimpleTransformer)->transformCollection($model->lastTenants);

           // @TODO discuss why used this
            if ($model->tenants_count > 2) {
                $response['tenants_count'] = $model->tenants_count - 2;
            }
        }

        if ($model->relationExists('serviceProviders')) {
            $response['service_providers'] = (new ServiceProviderTransformer)->transformCollection($model->serviceProviders);
        }

        if ($model->relationExists('propertyManagers')) {
            $response['managers'] = (new PropertyManagerSimpleTransformer)->transformCollection($model->propertyManagers);
            $response['managers_last'] = (new PropertyManagerSimpleTransformer)->transformCollection($model->lastPropertyManagers);
            if ($model->property_managers_count > 2) {
                $response['property_managers_count'] = $model->property_managers_count - 2;
            }
        }

        if ($model->relationExists('media')) {
            $response['media'] = (new MediaTransformer)->transformCollection($model->media);
        }

        return $response;
    }

    /**
     * Transform Request to Address entity.
     *
     * @param array $input
     *
     * @return array
     */
    public function transformRequest(array $input)
    {
        if (!isset($input['address'])) {
            $input['address'] = [];
        }

        return $input;
    }

    /**
     * Include Address
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeAddress(Building $building)
    {
        $address = $building->address;

        return $this->item($address, new AddressTransformer);
    }
}
