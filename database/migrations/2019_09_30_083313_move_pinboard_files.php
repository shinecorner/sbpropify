<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MovePinboardFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $postFiles = \Illuminate\Support\Facades\Storage::disk('public')->allFiles('posts');
        foreach ($postFiles as $fileName) {
            $pinboardfileName = str_replace('posts', 'pinboard', $fileName);
            \Illuminate\Support\Facades\Storage::disk('public')->move($fileName, $pinboardfileName);
        }
        \Illuminate\Support\Facades\Storage::disk('public')->deleteDirectory('posts');
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
