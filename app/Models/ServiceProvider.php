<?php

namespace App\Models;

use App\Traits\RequestRelation;
use App\Traits\UniqueIDFormat;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * @SWG\Definition(
 *      definition="ServiceProvider",
 *      required={"name"},
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
 *          property="address_id",
 *          description="address_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="category",
 *          description="category",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="email",
 *          description="email",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="phone",
 *          description="phone",
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
class ServiceProvider extends AuditableModel
{
    use Notifiable;
    use SoftDeletes;
    use UniqueIDFormat;
    use RequestRelation;

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
        'category' => 'required|integer|max:255',
        'phone' => 'required|string|max:255',
        'user' => 'required',
        'address' => 'required',
    ];

    public static $rulesUpdate = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
        'category' => 'required|integer|max:255',
        'phone' => 'required|string|max:255',
    ];

    public $table = 'service_providers';

    const ServiceProviderCategoryElectrician = 1;
    const ServiceProviderCategoryHeatingCompany = 2;
    const ServiceProviderCategoryLift = 3;
    const ServiceProviderCategorySanitary = 4;
    const ServiceProviderCategoryKeyService = 5;
    const ServiceProviderCategoryCaretaker = 6;
    const ServiceProviderCategoryRealEstateService = 7;

    const ServiceProviderCategory = [
        self::ServiceProviderCategoryElectrician => 'electrician',
        self::ServiceProviderCategoryHeatingCompany => 'heating_company',
        self::ServiceProviderCategoryLift => 'lift',
        self::ServiceProviderCategorySanitary => 'sanitary',
        self::ServiceProviderCategoryKeyService => 'key_service',
        self::ServiceProviderCategoryCaretaker => 'caretaker',
        self::ServiceProviderCategoryRealEstateService => 'real_estate_service',
    ];

    public $fillable = [
        'user_id',
        'address_id',
        'category',
        'name',
        'email',
        'phone',
    ];
    protected $dates = ['deleted_at'];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'address_id' => 'integer',
        'category' => 'string',
        'name' => 'string',
        'email' => 'string',
        'phone' => 'string',
        'service_provider_format' => 'string',
    ];

    /**
     * @var array
     */
    protected $auditEvents = [
        AuditableModel::EventCreated,
        AuditableModel::EventUpdated,
        AuditableModel::EventDeleted,
        AuditableModel::EventQuarterAssigned => 'getAttachedEventAttributes',
        AuditableModel::EventBuildingAssigned => 'getAttachedEventAttributes',
        AuditableModel::EventQuarterUnassigned => 'getDetachedEventAttributes',
        AuditableModel::EventBuildingUnassigned => 'getDetachedEventAttributes',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function settings()
    {
        return $this->hasOne(UserSettings::class, 'user_id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function address()
    {
        return $this->hasOne(Address::class, 'id', 'address_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function buildings()
    {
        return $this->belongsToMany(Building::class, 'building_service_provider', 'service_provider_id', 'building_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function quarters()
    {
        return $this->belongsToMany(Quarter::class, 'quarter_service_provider', 'service_provider_id', 'quarter_id');
    }

    // @TODO remove
    public function setCategoryAttribute($value)
    {
        $this->attributes['category'] = array_flip(ServiceProvider::ServiceProviderCategory)[$value] ?? $value;
    }

    /**
     * @return array|string|null
     */
    public function getCategoryNameEnAttribute()
    {
        return $this->categoryTranslation('en');
    }

    /**
     * @return array|string|null
     */
    public function getCategoryNameDeAttribute()
    {
        return $this->categoryTranslation('de');
    }

    /**
     * @return array|string|null
     */
    public function getCategoryNameFrAttribute()
    {
        return $this->categoryTranslation('fr');
    }

    /**
     * @return array|string|null
     */
    public function getCategoryNameItAttribute()
    {
        return $this->categoryTranslation('it');
    }

    protected function categoryTranslation($lang)
    {
        if (!empty(ServiceProvider::ServiceProviderCategory[$this->attributes['category']])) {
            return __('models.service.category.' . ServiceProvider::ServiceProviderCategory[$this->attributes['category']], [], $lang);
        }
        
        return '';
    }
}
