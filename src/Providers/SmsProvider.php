<?php

namespace Fibdesign\Sms\Providers;
use Illuminate\Support\ServiceProvider;

class SmsProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/sms.php' => config_path('sms.php'),
        ]);
    }
}
