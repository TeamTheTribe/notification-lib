<?php

namespace TheTribe\NotificationMS\Laravel;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use TheTribe\NotificationMS\Laravel\Contracts\IdentifierGetter;
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
        $this->app->bind(IdentifierGetter::class, config("notifications.identifier_implementation"));
    }

    protected function getNotificationsUrl(): string
    {
        $env = config('app.env');
        return config("notifications.url.{$env}");
    }
}