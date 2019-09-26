<?php

namespace App\Models;

use Illuminate\Validation\Rule;

/**
 * @SWG\Definition(
 *      definition="PinnedEmailReceptionist",
 *      required={"content"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="post_id",
 *          description="post_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="tenant_ids",
 *          description="tenant_ids",
 *          type="array",
 *          @SWG\Items(
 *              type="integer"
 *          )
 *      ),
 *      @SWG\Property(
 *          property="failed_tenant_ids",
 *          description="failed_tenant_ids",
 *          type="array",
 *          @SWG\Items(
 *              type="integer"
 *          )
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
class PinnedEmailReceptionist extends Model
{
    public $fillable = [
        'post_id',
        'tenant_ids',
        'failed_tenant_ids'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'post_id' => 'integer',
        'tenant_ids' => 'array',
        'failed_tenant_ids' => 'array'
    ];

    /**
     * Validation rules
     *
     * @return array
     * @var array
     */
    public static function rules()
    {
        $categories = array_keys(self::Category);
        $categories[] = null;
        $re = RealEstate::first();
        $visibilities = self::Visibility;
        if (!$re->quarter_enable) {
            unset($visibilities[self::VisibilityQuarter]);
        }
        return [
            'content' => 'required',
            'visibility' => ['required', Rule::in(array_keys($visibilities))],
            'category' => [Rule::in($categories)],
            'pinned' => function ($attribute, $value, $fail) {
                if ($value && !\Auth::user()->can('pin-post')) {
                    $fail($attribute.' must be false.');
                }
            },
            'pinned_to' => Rule::requiredIf(request()->pinned),
            'execution_start' => 'nullable|date',
            'execution_end' => 'nullable|date|after_or_equal:execution_start',
        ];
    }

    /**
     * Publish validation rules
     *
     * @return array
     * @var array
     */
    public static function publishRules()
    {
        return [
            'status' => ['required', Rule::in(array_keys(self::Status))]
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function post()
    {
        return $this->belongsTo(Pinboard::class, 'post_id', 'id');
    }
}
