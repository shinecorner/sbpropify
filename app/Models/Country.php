<?php

namespace App\Models;

/**
 * @SWG\Definition(
 *      definition="Country",
 *      required={"name", "code"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *     @SWG\Property(
 *          property="code",
 *          description="code",
 *          type="string"
 *      ),
 *     @SWG\Property(
 *          property="alpfa_3",
 *          description="alpfa_3",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="name_de",
 *          description="name_de",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="name_fr",
 *          description="name_fr",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="name_it",
 *          description="name_it",
 *          type="string"
 *      ),
 *
 * )
 */
class Country extends Model
{
    /**
     * @var string
     */
    public $table = 'loc_countries';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    public $fillable = [
        'name',
        'code',
        'alpha_3',
        'name_de',
        'name_fr',
        'name_it',
        'name_rm'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'code' => 'string',
        'alpha_3' => 'string',
        'name' => 'string',
        'name_de' => 'string',
        'name_fr' => 'string',
        'name_it' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'code' => 'required',
        'alpha_3' => 'required',
        'name' => 'required',
        'name_de' => 'required',
        'name_fr' => 'required',
        'name_it' => 'required',
    ];
}
