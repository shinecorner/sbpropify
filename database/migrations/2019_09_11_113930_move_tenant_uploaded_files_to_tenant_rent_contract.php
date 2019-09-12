<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveTenantUploadedFilesToTenantRentContract extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Models\Media::where('model_type', \App\Models\Building::class)->update(['model_type' => get_morph_type_of(\App\Models\Building::class)]);
        \App\Models\Media::where('model_type', \App\Models\Tenant::class)->update(['model_type' => get_morph_type_of(\App\Models\Tenant::class)]);
        $medias = \App\Models\Media::where('model_type', get_morph_type_of(\App\Models\Tenant::class))->get();
        $tenants = \App\Models\Tenant::whereIn('id', $medias->pluck('model_id'))->with('tenant_rent_contracts', 'media')->get();
        $medias->each(function ($media) use ($tenants) {
            $tenant = $tenants->where('id', $media->model_id)->first();
            if ($tenant) {
                $tenantRentContract = $tenant->tenant_rent_contracts->first();
                if (empty($tenantRentContract)) {
                    $tenantRentContract = \App\Models\TenantRentContract::create([
                        'tenant_id' => $tenant->id,
                        'building_id' => $tenant->building_id,
                        'unit_id' => $tenant->unit_id,
                        'start_date' => now(),
                        'end_date' => $tenant->rent_end
                    ]);
                }

                if (\Illuminate\Support\Facades\Storage::disk('local')->exists('public\tenants\media\\' . $media->id)) {
                    \Illuminate\Support\Facades\Storage::disk('local')->copy('public\tenants\media\\' . $media->id, 'public\tenant-rent-contracts\media\\' . $media->id);
                }

                $media->update([
                    'model_type' => get_morph_type_of(\App\Models\TenantRentContract::class),
                    'model_id' => $tenantRentContract->id,
                    'disk' => 'tenant_rent_contracts_media',
                ]);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tenant_rent_contract', function (Blueprint $table) {
            //
        });
    }
}
