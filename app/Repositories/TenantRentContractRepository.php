<?php

namespace App\Repositories;

use App\Models\TenantRentContract;

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
}
