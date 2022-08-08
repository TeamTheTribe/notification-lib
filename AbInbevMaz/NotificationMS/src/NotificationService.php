<?php

namespace AbInbevMaz\NotificationMS;

use GuzzleHttp\Client;

final class NotificationService
{
    private $appURL;
    private $notificationURL;
    protected $client;

    public function __construct(string $appURL, string $notificationURL)
    {
        $this->appURL = $appURL;
        $this->notificationURL = $notificationURL;
        $this->client = new Client();
    }

    public function save(array $content, array $params, string $action, int $categoryId, ?string $groupId = NULL)
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

        $response = $this->client->request('PUT', $this->notificationURL, [
            'headers' => $headers,
            'body' => json_encode($body)
        ]);



        return [
            'code' => $response->getStatusCode(),
            'body' => $response->getBody()
        ];
    }

}
