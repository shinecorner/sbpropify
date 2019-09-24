<?php

namespace App\Models;

use App\Traits\UniqueIDFormat;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\AuditableObserver;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * @SWG\Definition(
 *      definition="RentContract",
 *      required={"first_name", "birthdate"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="tenant_id",
 *          description="tenant_id",
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
 *          property="type",
 *          description="type",
 *          type="integer"
 *      ),
 *     @SWG\Property(
 *          property="duration",
 *          description="duration",
 *          type="integer"
 *      ),
 *     @SWG\Property(
 *          property="status",
 *          description="status",
 *          type="integer"
 *      ),
 *     @SWG\Property(
 *          property="rent_contract_format",
 *          description="rent_contract_format",
 *          type="integer"
 *      ),
 *     @SWG\Property(
 *          property="deposit_type",
 *          description="deposit_type",
 *          type="integer"
 *      ),
 *     @SWG\Property(
 *          property="deposit_status",
 *          description="deposit_status",
 *          type="integer"
 *      ),
 *     @SWG\Property(
 *          property="deposit_amount",
 *          description="deposit_amount",
 *          type="integer"
 *      ),
 *     @SWG\Property(
 *          property="net_rent",
 *          description="net_rent",
 *          type="integer"
 *      ),
 *     @SWG\Property(
 *          property="operating_cost",
 *          description="operating_cost",
 *          type="integer"
 *      ),
 *     @SWG\Property(
 *          property="gross_rent",
 *          description="gross_rent",
 *          type="integer"
 *      ),
 *     @SWG\Property(
 *          property="parking_price",
 *          description="parking_price",
 *          type="integer"
 *      ),
 *     @SWG\Property(
 *          property="start_date",
 *          description="start_date",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="end_date",
 *          description="end_date",
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
class RentContract extends AuditableModel implements HasMedia
{
    use HasMediaTrait, UniqueIDFormat;

    const TypePrivate = 1;
    const TypeBusiness = 2;
    const TypeParkingSlot = 3;
    const Type = [
        self::TypePrivate => 'private',
        self::TypeBusiness => 'business',
        self::TypeParkingSlot => 'parking slot'
    ];

    const DurationUnlimited = 1;
    const DurationLimited = 2;
    const Duration = [
        self::DurationUnlimited => 'unlimited',
        self::DurationLimited => 'limited',
    ];
    
    const StatusActive = 1;
    const StatusInactive = 2;
    const Status = [
        self::StatusActive => 'active',
        self::StatusInactive => 'inactive',
    ];

    const DepositTypeBankDepot = 1;
    const DepositTypeBankGuarantee = 2;
    const DepositTypeInsurance = 3;
    const DepositTypeOther = 4;
    const DepositType = [
        self::DepositTypeBankDepot => 'Bank depot',
        self::DepositTypeBankGuarantee => 'Bank guarantee',
        self::DepositTypeInsurance => 'Insurance',
        self::DepositTypeOther => 'Other'
    ];

    const DepositStatusYes = 1;
    const DepositStatusNo = 2;
    const DepositStatus = [
        self::DepositStatusYes => 'yes',
        self::DepositStatusNo => 'no',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'tenant_id' => 'required|integer|exists:tenants,id',
        'building_id' => 'integer|exists:buildings,id',
        'unit_id' => 'integer|exists:units,id',
        'start_date' => 'date',
        'end_date' => 'date|after_or_equal:start_date',
        'status' => 'digits_between:1,2|numeric',
        'type' => 'digits_between:1,3|numeric',
        'duration' => 'digits_between:1,2|numeric',
        'deposit_type' => 'digits_between:1,4|numeric',
        'deposit_status' => 'digits_between:1,2|numeric',
        'deposit_amount' => 'numeric',
        'net_rent' => 'numeric',
        'operating_cost' => 'numeric',
        'gross_rent' => 'numeric',
        'parking_price' => 'numeric',
    ];

    protected $table = 'tenant_rent_contracts';

    /**
     * @var array
     */
    public $fillable = [
        'tenant_id',
        'building_id',
        'unit_id',
        'type',
        'duration',
        'status',
        'rent_contract_format',
        'deposit_type',
        'deposit_status',
        'deposit_amount',
        'net_rent',
        'operating_cost',
        'gross_rent',
        'parking_price',
        'start_date',
        'end_date',
    ];

    /**
     * @var array
     */
    protected $dates = ['deleted_at', 'start_date', 'end_date'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'tenant_id' => 'integer',
        'building_id' => 'integer',
        'unit_id' => 'integer',
        'type' => 'integer',
        'duration' => 'integer',
        'status' => 'integer',
        'rent_contract_formats' => 'string',
        'deposit_type' => 'integer',
        'deposit_status' => 'integer',
        'deposit_amount' => 'integer',
        'net_rent' => 'integer',
        'operating_cost' => 'integer',
        'gross_rent' => 'integer',
        'parking_price' => 'integer',
    ];

    /**
     * @return BelongsTo
     **/
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'id');
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
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

    protected function getFormatColumnName()
    {
        return 'rent_contract_format';
    }
}
