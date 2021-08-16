<?php

namespace App\Repositories\Http;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class PaymentNotificationRepository
{
    private Client $client;
    private string $url;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->url    = env('NOTIFICATION_API_URL');
    }

    public function send(): ResponseInterface
    {
        return $this->client->request('GET', $this->url);
    }
}
