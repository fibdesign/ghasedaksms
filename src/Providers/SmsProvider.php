<?php

namespace Fibdesign\Sms\Providers;
use Illuminate\Support\ServiceProvider;

class SmsProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfig();
    }

    public function boot()
    {
        $this->publishConfig();
    }

    private function mergeConfig()
    {
        $path = $this->getConfigPath();
        $this->mergeConfigFrom($path, 'sms');
    }

    private function publishConfig()
    {
        $path = $this->getConfigPath();
        $this->publishes([$path => config_path('sms.php')], 'config');
    }

    private function getConfigPath(): string
    {
        return __DIR__ . '/../config/sms.php';
    }



}
