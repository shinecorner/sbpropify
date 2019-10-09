<?php

namespace App\Models;

use App\Traits\HashId;
use App\Traits\RequestRelation;
use App\Traits\UniqueIDFormat;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\AuditableObserver;
use PDF;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Support\Facades\Storage;

/**
 * @SWG\Definition(
 *      definition="Tenant",
 *      required={"first_name", "birthdate"},
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
 *     @SWG\Property(
 *          property="default_rent_contract_id",
 *          description="default_rent_contract_id",
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
 *          property="building_id",
 *          description="building_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="unit_id",
 *          description="unit_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="client_type",
 *          description="client_type",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="title",
 *          description="title",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="company",
 *          description="company",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="first_name",
 *          description="first_name",
 *          type="string"
 *      ),
 *     @SWG\Property(
 *          property="last_name",
 *          description="last_name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="birth_date",
 *          description="birth_date",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="mobile_phone",
 *          description="mobile_phone",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="private_phone",
 *          description="private_phone",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="work_phone",
 *          description="work_phone",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="rent_start",
 *          description="rent_start",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="rent_end",
 *          description="rent_end",
 *          type="string",
 *          format="date"
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
class Tenant extends AuditableModel implements HasMedia
{
    use HasMediaTrait, UniqueIDFormat, HashId, RequestRelation;

    const TitleCompany = 'company';
    const TitleMr = 'mr';
    const TitleMrs = 'mrs';
    const Title = [
        self::TitleMr,
        self::TitleMrs,
        self::TitleCompany
    ];

    const StatusActive = 1;
    const StatusNotActive = 2;
    const Status = [
        self::StatusActive => 'active',
        self::StatusNotActive => 'not_active',
    ];

    const ClientTypeTenant = 1;
    const ClientTypeOwner = 2;
    const ClientType = [
        self::ClientTypeTenant => 'tenant',
        self::ClientTypeOwner => 'owner',
    ];
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'default_rent_contract_id' => 'exists:tenant_rent_contracts,id',// @TODO check own or not
        'title' => 'required|string',
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'birth_date' => 'date',
        'rent_start' => 'date',
        'rent_end' => 'date|after_or_equal:rent_start',
        'status' => 'digits_between:1,2|numeric'
    ];

    /**
     * @var string
     */
    public $table = 'tenants';

    /**
     * @var array
     */
    public $fillable = [
        'user_id',
        'default_rent_contract_id',
        'address_id',
        'building_id',
        'unit_id',
        'title',
        'company',
        'first_name',
        'last_name',
        'birth_date',
        'mobile_phone',
        'private_phone',
        'work_phone',
        'status',
        'rent_start',
        'rent_end',
        'tenant_format',
        'review',
        'rating',
        'nation',
        'country_id',
        'client_type',
    ];

    protected $dates = ['deleted_at', 'rent_start', 'rent_end'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'address_id' => 'integer',
        'building_id' => 'integer',
        'country_id' => 'integer',
        'unit_id' => 'integer',
        'title' => 'string',
        'company' => 'string',
        'first_name' => 'string',
        'last_name' => 'string',
        'birth_date' => 'date',
        'rent_start' => 'date',
        'rent_end' => 'date',
        'mobile_phone' => 'string',
        'private_phone' => 'string',
        'work_phone' => 'string',
        'status' => 'integer',
        'tenant_format' => 'string',
        'review' => 'string',
        'rating' => 'integer',
        'client_type' => 'integer',
        'nation' => 'string',
    ];

    const templateMap = [
        'first_name' => 'tenant.first_name',
        'last_name' => 'tenant.last_name',
        'email' => 'user.email',
    ];

    public static function boot()
    {
        parent::boot();

        static::created(function ($tenant) {
            $old = AuditableObserver::$restoring;
            AuditableObserver::$restoring = true;

            $tenant->activation_code = $tenant->shortHashId($tenant->id);
            $tenant->save();

            AuditableObserver::$restoring = $old;
        });

        static::deleting(function ($tenant) {
            $tenant->user->settings()->forceDelete();
            $tenant->user()->forceDelete();
        });
    }

    /**
     * @return BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function settings()
    {
        return $this->hasOne(UserSettings::class, 'user_id', 'user_id');
    }

    /**
     * @return BelongsTo
     **/
    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id', 'id');
    }

    /**
     * @return BelongsTo
     **/
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection('documents');
    }

    /**
     * @return BelongsTo
     **/
    public function building()
    {
        return $this->belongsTo(Building::class, 'building_id', 'id');
    }

    /**
     * @return BelongsTo
     **/
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    /**
     * @return HasMany
     **/
    public function requests()
    {
        return $this->hasMany(Request::class, 'tenant_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function rent_contracts()
    {
        return $this->hasMany(RentContract::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function default_rent_contract()
    {
        return $this->belongsTo(RentContract::class);
    }

    public function homeless()
    {
        return ! $this->rent_contracts()
            ->where('tenant_rent_contracts.status', RentContract::StatusActive)
            ->whereNotNull('tenant_rent_contracts.building_id')->count();
    }

    public function active_rent_contracts_with_building()
    {
        return $this->rent_contracts()
            ->where('tenant_rent_contracts.status', RentContract::StatusActive)
            ->whereNotNull('tenant_rent_contracts.building_id');
    }

    /**
     * @param $tenant_id
     * @param $language
     */
    public function setCredentialsPDF()
    {
        $settings = Settings::firstOrFail();
        $data = [
            'tenant' => $this,
            'settings' => $settings,
            'url' => url('/activate'),
            'code' => $this->activation_code,
            'language'  => $this->settings->language
        ];

        $pdf = PDF::loadView('pdfs.tenantCredentialsXtended', $data);

        Storage::disk('tenant_credentials')->put($this->pdfXFileName(), $pdf->output());
        $pdf = PDF::loadView('pdfs.tenantCredentials', $data);
        Storage::disk('tenant_credentials')->put($this->pdfFilename(), $pdf->output());
    }

    public function pdfXFileName()
    {
        $language  = $this->settings->language;
        return $this->id . '-' . $language . '-X.pdf';
    }

    public function pdfFileName()
    {
        $language  = $this->settings->language;
        return $this->id . '-' . $language . '.pdf';
    }

    public function getNameAttribute()
    {
        return $this->title . " " . $this->first_name . " " . $this->last_name;
    }
}
