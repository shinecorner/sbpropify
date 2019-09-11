<?php

namespace App\Repositories;

use App\Models\TenantRentContract;
use App\Models\Unit;

/**
 * Class TenantRentContractRepository
 * @package App\Repositories
 */
class TenantRentContractRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $mimeToExtension = [
        "application/pdf" => "pdf",
        "image/png" => "png",
        "image/jpeg" => "jpg",
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return TenantRentContract::class;
    }

    /**
     * @param array $attributes
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function create(array $attributes)
    {
        if (isset($attributes['unit_id'])) {
            $unit = Unit::with('building')->find($attributes['unit_id']);
            if ($unit) {
                $attributes['building_id'] = $unit->building_id;
                $attributes['unit_id'] = $unit->id;
            }
            unset($attributes['unit']);
        }

        return parent::create($attributes);
    }
}
