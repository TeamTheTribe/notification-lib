<?php

namespace TheTribe\NotificationMS\Laravel;

use Exception;
use Illuminate\Http\Request;
use TheTribe\NotificationMS\NotificationService;

final class NotificationController
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function getNotifications(Request $request)
    {
        $sharpId = $request->session()->get("sharp_id");
        if(is_null($sharpId)){
            throw new Exception("No existe la variable de session sharp_id");
        }
        $response = $this->notificationService->getNotifications($sharpId);
        return response()->json($response->getBody(), $response->getStatusCode());
    }

    public function save(Request $request)
    {
        $response = $this->notificationService->save(
            $request->get("content"), 
            $request->get("params"),
            $request->get("action"),
            $request->get("category_id"),
            $request->get("group_id")
        );
        return response()->json($response->getBody(), $response->getStatusCode());
    }

    public function readNotification(Request $request, $notificationId)
    {
        $sharpId = $request->session()->get("sharp_id");
        if(is_null($sharpId)){
            throw new Exception("No existe la variable de session sharp_id");
        }
        $response = $this->notificationService->readNotification($notificationId, $sharpId);
        return response()->json($response->getBody(), $response->getStatusCode());
    }

    public function deleteNotification(Request $request, $notificationId)
    {
        $sharpId = $request->session()->get("sharp_id");
        if(is_null($sharpId)){
            throw new Exception("No existe la variable de session sharp_id");
        }
        $response = $this->notificationService->deleteNotification($notificationId, $sharpId);
        return response()->json($response->getBody(), $response->getStatusCode());
    }
}