<?php

namespace TheTribe\NotificationMS\Laravel;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use TheTribe\NotificationMS\NotificationService;

final class ServiceProvider extends LaravelServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/notifications.php');
        $this->publishes([
            __DIR__.'/config/notifications.php' => config_path('notifications.php'),
        ]);
    }

    public function register()
    {
        $this->app->singleton(NotificationService::class, function($app){
            return new NotificationService(config("app.url"), $this->getNotificationsUrl());
        });
    }

    protected function getNotificationsUrl(): string
    {
        switch (config("app.env")) {
            case 'develop':
                return config("notifications.url.develop");
            case 'stage':
                return config("notifications.url.stage");
            default:
                return config("notifications.url.production");
        }
    }
}