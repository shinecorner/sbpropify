<?php

namespace App\Traits;


use App\Models\ServiceRequest;
use Illuminate\Support\Str;

trait RequestRelation
{
    public function requests()
    {
        return $this->morphToMany(ServiceRequest::class, 'assignee', 'request_assignees', 'assignee_id', 'request_id');
    }

    public function pendingRequests()
    {
        return $this->requests()->whereIn('service_requests.status', ServiceRequest::PendingStatuses);
    }

    public function solvedRequests()
    {
        return $this->requests()->whereIn('service_requests.status', ServiceRequest::SolvedStatuses);
    }

    public function __call($name, $arguments)
    {
        if (Str::startsWith($name, 'requests')) {
            $status = substr($name, strlen('requests'));
            $statusFullName = ServiceRequest::class . '::Status' . $status;
            if (defined($statusFullName)) {
                return $this->requests()->where('service_requests.status', constant($statusFullName));
            }
        }
        return parent::__call($name, $arguments);
    }
}
