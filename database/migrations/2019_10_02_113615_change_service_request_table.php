<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeServiceRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Models\ServiceRequest::get()->each(function ($serviceRequest) {
           $this->fixValue($serviceRequest, 'room', \App\Models\ServiceRequest::Room);
           $this->fixValue($serviceRequest, 'payer', \App\Models\ServiceRequest::Payer);
            $this->fixValue($serviceRequest, 'capture_phase', \App\Models\ServiceRequest::CapturePhase);
            $serviceRequest->save();
        });

        \Illuminate\Support\Facades\DB::statement('ALTER TABLE `service_requests` CHANGE `payer` `payer` TINYINT(191) NULL DEFAULT NULL;');
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE `service_requests` CHANGE `capture_phase` `capture_phase` TINYINT(191) NULL DEFAULT NULL;');
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE `service_requests` CHANGE `room` `room` TINYINT(191) NULL DEFAULT NULL;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }

    protected function fixValue($serviceRequest, $col, $constants)
    {
        $value = $serviceRequest->{$col};
        if (empty($value) || is_integer($value)) {
            return $serviceRequest;
        }
        $constants = array_flip($constants);
        $serviceRequest->{$col} =  $constants[$value] ?? head($constants);
        return $serviceRequest;
    }
}

