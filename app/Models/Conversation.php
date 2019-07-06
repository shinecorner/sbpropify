<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasComments;

/**
 * @SWG\Definition(
 *      definition="Conversation",
 *      required={"conversation"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class Conversation extends Model
{
    use HasComments;
    protected $fillable = [];

    /**
     * Validation rules
     *
     * @var array
     */
    public static function rules()
    {
        return [];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function scopeOfLoggedInUser($query)
    {
        return $query->whereHas('users', function($q) {
            return $q->where('id', \Auth::id());
        });
    }
}
