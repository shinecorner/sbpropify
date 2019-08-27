<?php

namespace App\Models;

use App\Traits\AddressOwnerAudit;
use App\Traits\RequestRelation;
use App\Traits\UniqueIDFormat;
use Chelout\RelationshipEvents\Concerns\HasBelongsToManyEvents;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * @SWG\Definition(
 *      definition="Building",
 *      required={"name", "floor_nr"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="description",
 *          description="description",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="label",
 *          description="label",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="address_id",
 *          description="address_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="floor_nr",
 *          description="floor_nr",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="basement",
 *          description="basement",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="attic",
 *          description="attic",
 *          type="integer",
 *          format="int32"
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
class Building extends AuditableModel implements HasMedia
{
    use SoftDeletes, HasMediaTrait, UniqueIDFormat, AddressOwnerAudit, HasBelongsToManyEvents, RequestRelation;

    protected $auditEvents = [
        AuditableModel::EventCreated => 'getCreatedEventAttributesIncludeAddress',
        AuditableModel::EventUpdated => 'getUpdatedEventAttributesIncludeAddress',
        AuditableModel::EventDeleted
    ];

    const BuildingMediaCategories = [
        'house_rules',
        'operating_instructions',
        'care_instructions',
        'other',
    ];

    const ContactEnablesBasedRealEstate = 1;
    const ContactEnablesShow = 2;
    const ContactEnablesHide = 3;

    const BuildingContactEnables = [
        self::ContactEnablesBasedRealEstate => 'Reference Real Estate',
        self::ContactEnablesShow => 'Show',
        self::ContactEnablesHide => 'Hide',
    ];

    public $table = 'buildings';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'name',
        'description',
        'label',
        'address_id',
        'district_id',
        'floor_nr',
        'basement',
        'attic',
        'building_format',
        'longitude',
        'latitude',
        'contact_enable'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'label' => 'string',
        'address_id' => 'integer',
        'district_id' => 'integer',
        'floor_nr' => 'integer',
        'contact_enable' => 'integer',
        'basement' => 'boolean',
        'attic' => 'boolean',
        'building_format' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'floor_nr' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function address()
    {
        return $this->hasOne(Address::class, 'id', 'address_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function district()
    {
        return $this->hasOne(District::class, 'id', 'district_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function units()
    {
        return $this->belongsTo(Unit::class, 'id', 'building_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function serviceProviders()
    {
        return $this->belongsToMany(ServiceProvider::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function propertyManagers()
    {
        return $this->belongsToMany(PropertyManager::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function lastPropertyManagers()
    {
        return $this->belongsToMany(PropertyManager::class)->orderBy('id', 'DESC');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function tenants()
    {
        return $this->hasMany(Tenant::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activeTenants()
    {
        return $this->tenants()
            ->where('tenants.status', Tenant::StatusActive);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inActiveTenants()
    {
        return $this->tenants()
            ->where('tenants.status', Tenant::StatusNotActive);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function lastTenants()
    {
        return $this->hasMany(Tenant::class)->orderBy('id', 'DESC');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function requests()
    {
        return $this->hasManyThrough(ServiceRequest::class, Tenant::class);
    }

    public function registerMediaCollections()
    {
        foreach (self::BuildingMediaCategories as $category)  {
            $this->addMediaCollection($category);
        }
    }
}
