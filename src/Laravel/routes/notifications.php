<?php

use Illuminate\Support\Facades\Route;
use TheTribe\NotificationMS\Laravel\NotificationController;

Route::group(["prefix" => "api"], function () {
    Route::group(["prefix" => "notifications-ms"], function () {
        Route::get('/notifications.js', [NotificationController::class, "getResourceNotification"])
            ->name('api.v1_0.notifications.resource.get');
        Route::get('/', [NotificationController::class, "getNotifications"])
            ->name('api.v1_0.notifications.get');
        Route::put('/', [NotificationController::class, "save"])
            ->name('api.v1_0.notifications.put');
        Route::put('/{notification_id}', [NotificationController::class, "readNotification"])
            ->name('api.v1_0.notifications.read.put');
        Route::delete('/{notification_id}', [NotificationController::class, "deleteNotification"])
            ->name('api.v1_0.notifications.delete');
    });
});
