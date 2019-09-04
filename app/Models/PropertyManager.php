<?php

namespace App\Models;

use App\Traits\BuildingRelation;
use App\Traits\RequestRelation;
use App\Traits\UniqueIDFormat;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="PropertyManager",
 *      required={""},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="user_id",
 *          description="user_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="title",
 *          description="title",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="first_name",
 *          description="first_name",
 *          type="string"
 *      ),
 *     @SWG\Property(
 *          property="profession",
 *          description="profession",
 *          type="string"
 *      ),
 *     @SWG\Property(
 *          property="slogan",
 *          description="slogan",
 *          type="string"
 *      ),
 *     @SWG\Property(
 *          property="xing_url",
 *          description="xing_url",
 *          type="string"
 *      ),
 *     @SWG\Property(
 *          property="linkedin_url",
 *          description="linkedin_url",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class PropertyManager extends AuditableModel
{
    use SoftDeletes, UniqueIDFormat, RequestRelation, BuildingRelation;

    public $table = 'property_managers';

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        //'description' => 'sometimes|string',
        'first_name' => 'required|string',
        'last_name' => 'required|string',
    ];

    public static $rulesUpdate = [
        //'description' => 'sometimes|string',
        'first_name' => 'required|string',
        'last_name' => 'required|string',
    ];

    const Title = [
        'mr',
        'mrs',
    ];

    public $fillable = [
        'description',
        'user_id',
        'title',
        'first_name',
        'last_name',
        'profession',
        'slogan',
        'xing_url',
        'linkedin_url',
        'property_manager_format',
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'description' => 'string',
        'user_id' => 'integer',
        'title' => 'string',
        'first_name' => 'string',
        'last_name' => 'string',
        'profession' => 'string',
        'slogan' => 'string',
        'xing_url' => 'string',
        'linkedin_url' => 'string',
        'property_manager_format' => 'string',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @return mixed
     */
    public function settings()
    {
        return $this->hasOne(UserSettings::class, 'user_id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function quarters()
    {
        return $this->belongsToMany(Quarter::class, 'quarter_property_manager', 'property_manager_id', 'quarter_id');
    }
}
