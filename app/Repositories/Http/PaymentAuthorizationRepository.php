<?php

namespace App\Repositories\Http;


use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class PaymentAuthorizationRepository
{
    private Client $client;
    private string $url;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->url    = env('PAYMENT_CHECK_API_URL');
    }

    public function check(): ResponseInterface
    {
        return $this->client->request('GET', $this->url);
    }
}
