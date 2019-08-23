<?php

namespace App\Models;

/**
 * @SWG\Definition(
 *      definition="ServiceRequestAssignee",
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="item_id",
 *          description="related assigner id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="edit_id",
 *          description="@TODO must be delete",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="type",
 *          description="related assigner type",
 *          type="string",
 *          format="int32",
 *          enum={"user", "provider", "manager"}
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="email",
 *          description="emai;",
 *          type="string"
 *      ),
 * )
 */
class ServiceRequestAssignee extends Model
{
    protected $table = 'request_assignees';

    public $timestamps = false;

    public $fillable = [
        'request_id',
        'assignee_id',
        'assignee_type',
        'created_at',
    ];
}
