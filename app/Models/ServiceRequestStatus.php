<?php

namespace App\Models;

use App\Traits\HasComments;
use App\Traits\UniqueIDFormat;
use Chelout\RelationshipEvents\Concerns\HasMorphedByManyEvents;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * @SWG\Definition(
 *      definition="ServiceRequestStatus",
 *      required={"old_status", "new_status", "started_at", "request_id"},
 *      @SWG\Property(
 *          property="request_id",
 *          description="request_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="old_status",
 *          description="old_status",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="new_status",
 *          description="new_status",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="started_at",
 *          description="started_at",
 *          type="string"
 *      ),
 * )
 */
class ServiceRequestStatus extends Model
{
    use SoftDeletes;

    public $table = 'request_status_log';

    public $fillable = [
        'request_id',
        'old_status',
        'new_status',
        'stared_at',
    ];
}
