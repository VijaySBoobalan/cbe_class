<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Twilio\Rest\Client;

class TwilioProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('twilio', function() {
            return new Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('twilio', function() {
            return new Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));
        });
    }
}
