<?php

namespace App\Transformers;

use App\Models\AnnouncementEmailReceptionist;
use App\Models\Tenant;

/**
 * Class AnnouncementEmailReceptionistTransformer.
 *
 * @package namespace App\Transformers;
 */
class AnnouncementEmailReceptionistTransformer extends BaseTransformer
{
    protected $defaultIncludes = [];

    /**
     * Transform the Pinboard entity.
     *
     * @param \App\Models\AnnouncementEmailReceptionist $model
     *
     * @return array
     */
    public function transform(AnnouncementEmailReceptionist $model)
    {
        $response = [
            'pinboard_id' => $model->pinboard_id,
            'tenant_ids' => $model->tenant_ids,
            'failed_tenant_ids' => $model->failed_tenant_ids,
        ];
        // @TODO improve load tenant data other place
        $tenants = Tenant::whereIn('id', $model->tenant_ids)->get(['id', 'first_name', 'last_name']);
        $response['tenants'] = $tenants->toArray();
        return $response;
    }
}
