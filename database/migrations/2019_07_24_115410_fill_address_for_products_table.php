<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FillAddressForProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (class_exists("App\Models\Address")) {
            \App\Models\Product::with('address')->get()->each(function ($product) {
                $product->country_id = $product->address->country_id ?? null;
                $product->state_id = $product->address->state_id ?? null;
                $product->city = $product->address->city ?? null;
                $product->street = $product->address->street ?? null;
                $product->street_nr = $product->address->street_nr ?? null;
                $product->zip = $product->address->zip ?? null;
                $product->save();
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
