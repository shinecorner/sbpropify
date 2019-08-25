<?php

namespace App\Traits;


use App\Models\ServiceRequest;

trait RequestRelation
{
    public function requests()
    {
        return $this->morphToMany(ServiceRequest::class, 'assignee', 'request_assignees', 'assignee_id', 'request_id');
    }

    public function requestsReceived()
    {
        return $this->requests()->where('service_requests.status', ServiceRequest::StatusReceived);
    }

    public function requestsInProcessing()
    {
        return $this->requests()->where('service_requests.status', ServiceRequest::StatusInProcessing);
    }

    public function requestsAssigned()
    {
        return $this->requests()->where('service_requests.status', ServiceRequest::StatusAssigned);
    }

    public function requestsDone()
    {
        return $this->requests()->where('service_requests.status', ServiceRequest::StatusDone);
    }

    public function requestsReactivated()
    {
        return $this->requests()->where('service_requests.status', ServiceRequest::StatusReactivated);
    }

    public function requestsArchived()
    {
        return $this->requests()->where('service_requests.status', ServiceRequest::StatusArchived);
    }

    public function pendingRequests()
    {
        return $this->requests()->whereIn('service_requests.status', ServiceRequest::PendingStatuses);
    }

    public function solvedRequests()
    {
        return $this->requests()->whereIn('service_requests.status', ServiceRequest::SolvedStatuses);
    }

}
