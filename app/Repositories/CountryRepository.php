<?php

namespace App\Repositories;

use App\Models\Country;

/**
 * Class CountryRepository
 * @package App\Repositories
 * @version January 26, 2019, 9:44 pm UTC
 *
 * @method Country findWithoutFail($id, $columns = ['*'])
 * @method Country find($id, $columns = ['*'])
 * @method Country first($columns = ['*'])
*/
class CountryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'code',
        'alpha_3',
        'name' => 'like',
        'name_de' => 'like',
        'name_fr' => 'like',
        'name_it' => 'like',
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Country::class;
    }
}
