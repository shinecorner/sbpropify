<?php

namespace App\Providers;

use Illuminate\Mail\TransportManager;
use App\Models\Settings;

class CustomTransportManager extends TransportManager {

    /**
     * Create a new manager instance.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return void
     */
    public function __construct($app, Settings $settings)
    {
        parent::__construct($app);
        $this->app['config']['mail'] = [
            'driver'        => env('MAIL_DRIVER', 'smtp'),
            'host'          => $settings->mail_host,
            'port'          => $settings->mail_port,
            'encryption'    => $settings->mail_encryption,
            'username'      => $settings->mail_username,
            'password'      => $settings->mail_password,
        ];
    }
}
