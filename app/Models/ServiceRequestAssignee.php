<?php

namespace App\Models;

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
