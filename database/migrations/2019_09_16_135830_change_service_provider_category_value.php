<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeServiceProviderCategoryValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (defined('\App\Models\ServiceProvider::ServiceProviderCategory')) {
            $categories = array_flip(\App\Models\ServiceProvider::ServiceProviderCategory);
            \App\Models\ServiceProvider::get(['id', 'category'])->each(function ($serviceProvider) use ($categories) {
                $value = $categories[$serviceProvider->category] ?? $serviceProvider->category;
                $serviceProvider->update(['category' => $value]);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
