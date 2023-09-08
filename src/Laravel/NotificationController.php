<?php

namespace TheTribe\NotificationMS\Laravel;

use Exception;
use Illuminate\Http\Request;
use TheTribe\NotificationMS\NotificationService;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use TheTribe\NotificationMS\Laravel\Contracts\IdentifierGetter;

final class NotificationController extends Controller
{
    protected $notificationService;
    protected $identifierGetter;

    public function __construct(
        NotificationService $notificationService,
        IdentifierGetter $identifierGetter
    )
    {
        $this->notificationService = $notificationService;
        $this->identifierGetter = $identifierGetter;
        $this->middleware(config("notifications.middleware"))->except('getResourceNotification');
    }

    public function getNotifications(Request $request)
    {
        $sharpId = $this->getIdentifierSharp($request);        
        if(is_null($sharpId)){
            throw new Exception("No existe la variable de session sharp_id");
        }
        $response = $this->notificationService->getNotifications($sharpId, $request->query("page", 1));
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
        $sharpId = $this->getIdentifierSharp($request);
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
        $sharpId = $this->getIdentifierSharp($request);
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
        return new Response($response, 200, [
            "Content-Type" => "text/javascript",
            "Pragma" => "no-cache",
            "Expires" => "0"
        ]);
    }

    public function getIdentifierSharp(Request $request){
        if(is_null($this->identifierGetter)){
            throw new Exception("There is no implementation for identifier getter");
        }
        return $this->identifierGetter->get();
    }
}