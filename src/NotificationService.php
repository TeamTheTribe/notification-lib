<?php

namespace TheTribe\NotificationMS;

use GuzzleHttp\Client;

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
        $headers = [
            'Content-Type' => 'application/json'
        ];

        return $this->client->request('GET', $this->notificationURL."/".$sharpId, [
            'headers' => $headers
        ]);
    }

    public function save(array $content, 
                        array $params, 
                        string $action, 
                        int $categoryId, 
                        ?string $groupId = NULL)
    {
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
    }

    public function readNotification(string $notificationId, string $sharpId)
    {
        $headers = [
            'Content-Type' => 'application/json'
        ];

        return $this->client->request('PUT', $this->notificationURL."/".$notificationId, [
            'headers' => $headers,
            'body' => ["sharp_id" => $sharpId]
        ]);
    }

    public function deleteNotification(string $notificationId, string $sharpId)
    {
        $headers = [
            'Content-Type' => 'application/json'
        ];

        return $this->client->request("DELETE", $this->notificationURL."/".$notificationId, [
            'headers' => $headers,
            'body' => ["sharp_id" => $sharpId]
        ]);
    }

}
