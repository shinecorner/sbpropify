<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewTagsInEmailTemplates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $tagMap = [
            'name' => 'user.name',
            'birthDate' => 'tenant.birthDate',
            'mobilePhone' => 'tenant.mobile_phone',
            'privatePhone' => 'tenant.private_phone',
            'email' => 'tenant.email',
            'phone' => 'tenant.phone',
            'title' => 'constant.tenant.title',
            'tenantCredentials' => 'tenantCredentials',
            'activationUrl' => 'activationUrl',
            'activationCode' => 'tenant.activation_code'
        ];
        $templateCategory = \App\Models\TemplateCategory::where('name', 'tenant_credentials')->first();
        if ($templateCategory) {
            $templateCategory->update(['tag_map' => $tagMap]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('email_templates', function (Blueprint $table) {
            //
        });
    }
}
