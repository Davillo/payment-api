<?php

namespace App\Services;

use App\Repositories\Http\PaymentAuthorizationRepository;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Response;

class PaymentAuthorizationService
{
    private PaymentAuthorizationRepository $paymentAuthorizationRepository;

    public function __construct(PaymentAuthorizationRepository $paymentAuthorizationRepository){
        $this->paymentAuthorizationRepository = $paymentAuthorizationRepository;
    }

    public function checkIfIsAuthorized(): bool
    {
        try {
            $response = $this->paymentAuthorizationRepository
                ->check();

            return $response->getStatusCode() === Response::HTTP_OK;
        }catch (ClientException $clientException){
            throw new \Exception('Error at the payment.');
        }
    }
}
