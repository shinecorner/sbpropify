<?php

namespace App\Transformers;

use App\Models\RealEstate;
use League\Fractal\TransformerAbstract;

/**
 * Class RealEstateTransformer.
 *
 * @package namespace App\Transformers;
 */
class RealEstateTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'user',
        'address',
    ];

    /**
     * Transform the RealEstate entity.
     *
     * @param \App\Models\RealEstate $model
     *
     * @return array
     */
    public function transform(RealEstate $model)
    {
        $ret = [
            'id' => $model->id,
            'name' => $model->name,
            'email' => $model->email,
            'phone' => $model->phone,
            'language' => $model->language,
            'logo' => $model->logo,
            'login_variation' => $model->login_variation,
            'login_variation_2_slider' => (bool) $model->login_variation_2_slider,
            'blank_pdf' => $model->blank_pdf,
            'quarter_enable' => $model->quarter_enable,
            'district_enable' => $model->quarter_enable,
            'contact_enable' => $model->contact_enable,
            'marketplace_approval_enable' => $model->marketplace_approval_enable,
            'news_approval_enable' => $model->news_approval_enable,
            'comment_update_timeout' => $model->comment_update_timeout,
            'free_apartments_enable' => $model->free_apartments_enable,
            'free_apartments_url' => $model->free_apartments_url,
            'opening_hours' => $model->opening_hours,
            'iframe_url' => $model->iframe_url,
            'iframe_enable' => $model->iframe_enable,
            'cleanify_email' => $model->cleanify_email,
            'news_receiver_ids' => $model->news_receiver_ids,
        ];
        if (\Auth::user()->can('edit-real_estate')) {
            $ret['mail_host'] = $model->mail_host;
            $ret['mail_port'] = $model->mail_port;
            $ret['mail_username'] = $model->mail_username;
            $ret['mail_password'] = $model->mail_password;
            $ret['mail_encryption'] = $model->mail_encryption;
            $ret['mail_from_address'] = $model->mail_from_address;
            $ret['mail_from_name'] = $model->mail_from_name;
        }


        if ($model->address) {
            $ret['address'] = (new AddressTransformer)->transform($model->address);
        }
        if (isset($model->news_receivers)) {
            $ret['news_receivers'] = (new UserTransformer)->transformCollection($model->news_receivers);
        }

        return $ret;
    }
}
