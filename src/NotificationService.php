<?php

namespace TheTribe\NotificationMS;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Throwable;

final class NotificationService
{
    private $appURL;
    private $notificationURL;
    private $endPoint;
    protected $client;

    public function __construct(string $appURL, string $notificationURL)
    {
        $this->client = new Client();
        $this->appURL = $appURL;
        $this->notificationURL = $notificationURL;
        $this->endPoint = $notificationURL . '/api/notifications';
    }

    public function getNotifications(string $sharpId, int $page = 1)
    {
        try {
            $headers = [
                'Content-Type' => 'application/json'
            ];
    
            return $this->client->request('GET', "$this->endPoint/$sharpId?page=$page", [
                'headers' => $headers
            ]);
        } catch (BadResponseException $th) {
            return $th->getResponse();
        }
        
    }

    public function save(array $content, 
                        array $params, 
                        string $action, 
                        int $categoryId, 
                        ?string $groupId = NULL)
    {
        try {
            $headers = [
                'Content-Type' => 'application/json',
                'Referer' => str_replace(['http://', 'https://'], '',  $this->appURL),
                'Host' =>  str_replace(['http://', 'https://'], '', $this->appURL)
            ];
    
            $body = [
                'content' => json_encode($content),
                'params' => json_encode($params),
                'action' => $action,
                'category_id' => $categoryId,
                'group_id' => $groupId,
            ];
    
            return $this->client->request('PUT', $this->endPoint, [
                'headers' => $headers,
                'body' => json_encode($body)
            ]);
        } catch (BadResponseException $th) {
            return $th->getResponse();
        }
    }

    public function readNotification(string $notificationId, string $sharpId)
    {
        try {
            $headers = [
                'Content-Type' => 'application/json'
            ];
    
            return $this->client->request('PUT', $this->endPoint."/".$notificationId, [
                'headers' => $headers,
                'form_params' => ["sharp_id" => $sharpId]
            ]);
        } catch (BadResponseException $th) {
            return $th->getResponse();
        }
        
    }

    public function deleteNotification(string $notificationId, string $sharpId)
    {
        try {
            $headers = [
                'Content-Type' => 'application/json'
            ];
    
            return $this->client->request("DELETE", $this->endPoint."/".$notificationId, [
                'headers' => $headers,
                'form_params' => ["sharp_id" => $sharpId]
            ]);
        } catch (BadResponseException $th) {
            return $th->getResponse();
        }
        
    }

    public function getResource()
    {
        $file = $this->notificationURL .'/js/notifications.js';

        try{
            header('Content-Type: text/javascript');
            header("Pragma: no-cache");
            header("Expires: 0");
            readfile($file);
            exit;
        }catch(Throwable $th){
            return $th;
        }
    }

}
