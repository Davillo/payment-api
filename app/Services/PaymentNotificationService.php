<?php

namespace App\Services;

use App\Repositories\Http\PaymentNotificationRepository;
use GuzzleHttp\Exception\ClientException;

class PaymentNotificationService
{
    private PaymentNotificationRepository $paymentNotificationRepository;

    public function __construct(
        PaymentNotificationRepository $paymentNotificationRepository
    )
    {
        $this->paymentNotificationRepository = $paymentNotificationRepository;
    }

    public function sendNotification(): void
    {
        try {
            $this->paymentNotificationRepository
                ->send();
        }catch (ClientException $clientException){
            throw new \Exception('Error notifying.');
        }
    }
}
