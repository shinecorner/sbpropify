<?php

namespace App\Repositories;

use App\Models\Quarter;

/**
 * Class QuarterRepository
 * @package App\Repositories
 * @version February 21, 2019, 9:27 pm UTC
 *
 * @method Quarter findWithoutFail($id, $columns = ['*'])
 * @method Quarter find($id, $columns = ['*'])
 * @method Quarter first($columns = ['*'])
 */
class QuarterRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name' => 'like',
        'description'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Quarter::class;
    }
}
