<?php

namespace App\Models;

use OwenIt\Auditing\Contracts\Auditable;

class AuditableModel extends Model implements Auditable
{
    use \App\Traits\Auditable;

    const EventCreated = 'created';
    const EventUpdated = 'updated';
    const EventDeleted = 'deleted';
    const EventUserAssigned = 'user_assigned';
    const EventUserUnassigned = 'user_unassigned';
    const EventManagerAssigned = 'manager_assigned';
    const EventManagerUnassigned = 'manager_unassigned';
    const EventProviderAssigned = 'provider_assigned';
    const EventProviderUnassigned = 'provider_unassigned';
    const EventProviderNotified = 'provider_notified';
    const EventMediaUploaded = 'media_uploaded';
    const EventMediaDeleted = 'media_deleted';

    const Events = [
        self::EventCreated,
        self::EventUpdated,
        self::EventDeleted,
        self::EventProviderAssigned,
        self::EventProviderUnassigned,
        self::EventProviderNotified,
        self::EventUserAssigned,
        self::EventUserUnassigned,
        self::EventManagerAssigned,
        self::EventManagerUnassigned,
        self::EventMediaUploaded,
        self::EventMediaDeleted,
    ];
}
