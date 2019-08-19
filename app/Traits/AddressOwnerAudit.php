<?php

namespace App\Traits;

trait AddressOwnerAudit
{
    public function getCreatedEventAttributesIncludeAddress()
    {
        $changes = $this->getCreatedEventAttributes();
        if ($this->address) {
            $changes[1] += $this->address->only($this->address->getFillable());
        }
        return $changes;
    }

    public function getUpdatedEventAttributesIncludeAddress()
    {
        // @TODO include audit changes
        $changes = $this->getUpdatedEventAttributes();
        return $changes;
    }
}
