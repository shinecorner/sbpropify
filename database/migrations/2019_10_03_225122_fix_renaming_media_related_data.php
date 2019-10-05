<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixRenamingMediaRelatedData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        update_db_fileds(\App\Models\TemplateCategory::class, ['name', 'description', 'tag_map', 'subject', 'body'], 'product', 'listing');
        update_db_fileds(\App\Models\Template::class, ['name', 'subject', 'body'], 'product', 'listing');

        update_db_fileds(\App\Models\Media::class, ['disk'], 'product', 'listing');
        $listingFiles = \Illuminate\Support\Facades\Storage::disk('public')->allFiles('products');
        foreach ($listingFiles as $fileName) {
            $pinboardfileName = str_replace('products', 'listings', $fileName);
            \Illuminate\Support\Facades\Storage::disk('public')->move($fileName, $pinboardfileName);
        }
        \Illuminate\Support\Facades\Storage::disk('public')->deleteDirectory('products');
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
