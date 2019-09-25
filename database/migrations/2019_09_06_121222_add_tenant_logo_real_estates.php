<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTenantLogoRealEstates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('real_estates', function (Blueprint $table) {
            $table->string('tenant_logo', 191)->nullable()->after('circle_logo');
            $table->string('pdf_font_family')->nullable()->after('tenant_logo');
        });
        //pdf_font_family
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('real_estates', function (Blueprint $table) {
            $table->dropColumn('tenant_logo', 'pdf_font_family');
        });
    }
}
