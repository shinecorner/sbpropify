<?php

namespace App\Providers;

use Illuminate\Mail\MailServiceProvider;
use App\Models\Settings;

class DBConfigMailServiceProvider extends MailServiceProvider
{
    /**
     *
     */
    protected function registerSwiftTransport(){
        $queueWork = [
            'artisan',
            'queue:work'
        ];
        if ('cli' == php_sapi_name() && isset($_SERVER['argv']) && array_diff($queueWork, $_SERVER['argv'])) {
            return;
        }
        $settings = Settings::first();

        if ($settings) {
            // Swift transport is not concerned about the `from` details
            config(['mail.from.address' => $settings->mail_from_address]);
            config(['mail.from.name' => $settings->mail_from_name]);

            $this->app->singleton('swift.transport', function ($app) use ($settings){
                return new CustomTransportManager($app, $settings);
            });
        }
    }
}
