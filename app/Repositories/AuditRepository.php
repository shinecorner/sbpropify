<?php

namespace App\Repositories;

use OwenIt\Auditing\Models\Audit;

/**
 * Class AuditRepository
 * @package App\Repositories
 * @version March 08, 2019, 9:44 pm UTC
 *
 * @method Audit findWithoutFail($id, $columns = ['*'])
 * @method Audit find($id, $columns = ['*'])
 * @method Audit first($columns = ['*'])
*/
class AuditRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'auditable_type',
        'auditable_id',
        'ip_address',
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Audit::class;
    }
}
