<?php

namespace TheTribe\NotificationMS\Laravel;

use Exception;
use Illuminate\Http\Request;
use TheTribe\NotificationMS\NotificationService;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;


final class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
        $this->middleware(config("notifications.middleware"))->except('getResourceNotification');
    }

    public function getNotifications(Request $request)
    {
        $sharpId = $request->session()->get("sharp_id");
        if(is_null($sharpId)){
            throw new Exception("No existe la variable de session sharp_id");
        }
        $response = $this->notificationService->getNotifications($sharpId);
        return response()->json(
            json_decode($response->getBody()->getContents()), 
            $response->getStatusCode()
        );
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
        return response()->json(
            json_decode($response->getBody()->getContents()), 
            $response->getStatusCode()
        );
    }

    public function readNotification(Request $request, $notificationId)
    {
        $sharpId = $request->session()->get("sharp_id");
        if(is_null($sharpId)){
            throw new Exception("No existe la variable de session sharp_id");
        }
        $response = $this->notificationService->readNotification($notificationId, $sharpId);
        return response()->json(
            json_decode($response->getBody()->getContents()), 
            $response->getStatusCode()
        );
    }

    public function deleteNotification(Request $request, $notificationId)
    {
        $sharpId = $request->session()->get("sharp_id");
        if(is_null($sharpId)){
            throw new Exception("No existe la variable de session sharp_id");
        }
        $response = $this->notificationService->deleteNotification($notificationId, $sharpId);
        return response()->json(
            json_decode($response->getBody()->getContents()), 
            $response->getStatusCode()
        );
    }

    public function getResourceNotification(){

        $response = $this->notificationService->getResource();
        if( $response instanceof \Throwable){
            Log::error(
                'Getting notification.js resource',
                [
                    'method'    => __METHOD__,
                    'class'     => $response->getFile(),
                    'line'      => $response->getLine(),
                    'message'   => $response->getMessage(),
                    'trace'     => $response->getTraceAsString(),
                ]
            );
            $response = '';
        }

        return new Response($response);
    }
}