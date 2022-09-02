<?php

namespace TheTribe\NotificationMS;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Throwable;

final class NotificationService
{
    private $appURL;
    private $notificationURL;
    protected $client;

    public function __construct(string $appURL, string $notificationURL)
    {
        $this->client = new Client();
        $this->appURL = $appURL;
        $this->notificationURL = $notificationURL;
    }

    public function getNotifications(string $sharpId)
    {
        try {
            $headers = [
                'Content-Type' => 'application/json'
            ];
    
            return $this->client->request('GET', $this->notificationURL."/".$sharpId, [
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
    
            return $this->client->request('PUT', $this->notificationURL, [
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
    
            return $this->client->request('PUT', $this->notificationURL."/".$notificationId, [
                'headers' => $headers,
                'body' => ["sharp_id" => $sharpId]
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
    
            return $this->client->request("DELETE", $this->notificationURL."/".$notificationId, [
                'headers' => $headers,
                'body' => ["sharp_id" => $sharpId]
            ]);
        } catch (BadResponseException $th) {
            return $th->getResponse();
        }
        
    }

    public function getResource()
    {
        $file = $this->notificationURL .'/js/notifications.js';

        try{
            header('Contet-Type: text/javascript');
            header('Content-type: text/js;');
            header("Pragma: no-cache");
            header("Expires: 0");
            readfile($file);
            exit;
        }catch(Throwable $th){
            return $th;
        }
    }

}
