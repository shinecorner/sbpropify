<?php

namespace App\Transformers;

use App\Models\PinnedEmailReceptionist;
use App\Models\Tenant;

/**
 * Class PinnedEmailReceptionistTransformer.
 *
 * @package namespace App\Transformers;
 */
class PinnedEmailReceptionistTransformer extends BaseTransformer
{
    protected $defaultIncludes = [];

    /**
     * Transform the Post entity.
     *
     * @param \App\Models\Post $model
     *
     * @return array
     */
    public function transform(PinnedEmailReceptionist $model)
    {
        $response = [
            'post_id' => $model->post_id,
            'tenant_ids' => $model->tenant_ids,
            'failed_tenant_ids' => $model->failed_tenant_ids,
        ];
        // @TODO improve load tenant data other place
        $tenants = Tenant::whereIn('id', $model->tenant_ids)->get(['id', 'first_name', 'last_name']);
        $response['tenants'] = $tenants->toArray();
        return $response;
    }
}
