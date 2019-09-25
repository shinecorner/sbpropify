<?php

namespace App\Providers;

use Illuminate\Mail\MailServiceProvider;
use App\Models\RealEstate;

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
        $re = RealEstate::first();

        if ($re) {
            // Swift transport is not concerned about the `from` details
            config(['mail.from.address' => $re->mail_from_address]);
            config(['mail.from.name' => $re->mail_from_name]);

            $this->app->singleton('swift.transport', function ($app) use ($re){
                return new CustomTransportManager($app, $re);
            });
        }
    }
}
