<?php

namespace App\Providers;

use Illuminate\Mail\TransportManager;
use App\Models\RealEstate;

class CustomTransportManager extends TransportManager {

    /**
     * Create a new manager instance.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return void
     */
    public function __construct($app, RealEstate $re)
    {
        $this->app = $app;
        $this->app['config']['mail'] = [
            'driver'        => env('MAIL_DRIVER', 'smtp'),
            'host'          => $re->mail_host,
            'port'          => $re->mail_port,
            'encryption'    => $re->mail_encryption,
            'username'      => $re->mail_username,
            'password'      => $re->mail_password,
        ];
    }
}
