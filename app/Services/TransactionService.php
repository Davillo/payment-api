<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\User;
use App\Repositories\TransactionRepository;
use App\Repositories\WalletRepository;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionService
{
    private const DEFAULT_PAGINATION_NUMBER = 15;

    private TransactionRepository $transactionRepository;
    private WalletRepository $walletRepository;
    private PaymentAuthorizationService $paymentAuthorizationService;
    private PaymentNotificationService $paymentNotificationService;

    public function __construct(
        TransactionRepository $transactionRepository,
        WalletRepository $walletRepository,
        PaymentAuthorizationService $paymentAuthorizationService,
        PaymentNotificationService $paymentNotificationService
    )
    {
        $this->transactionRepository            = $transactionRepository;
        $this->walletRepository                 = $walletRepository;
        $this->paymentAuthorizationService      = $paymentAuthorizationService;
        $this->paymentNotificationService       = $paymentNotificationService;
    }

    public function getAllPaginated(): LengthAwarePaginator
    {
        return $this->transactionRepository->paginate(self::DEFAULT_PAGINATION_NUMBER);
    }

    public function getById(int $id): ?Transaction
    {
        return $this->transactionRepository->getById($id);
    }

    public function store(array $data): Transaction
    {
        if ($data['payer_id'] === $data['payee_id']) {
            throw new Exception('Payee and Payer cant be the same user');
        }

        if($data['payer_id'] === User::USER_TYPE_SHOPKEEPER){
            throw new Exception('The payer cant be a shopkeeper');
        }

        $payerWallet = $this->walletRepository->getByUserId($data['payer_id']);
        $payeeWallet = $this->walletRepository->getByUserId($data['payee_id']);

        if ($data['value'] > $payerWallet->amount) {
            throw new Exception('Payer does not have the amount');
        }

        $transaction = $this->transactionRepository->store($data);

        try {
            DB::beginTransaction();
            DB::transaction(function () use ($transaction, $payerWallet, $payeeWallet) {
                $payerWalletValue = $payerWallet->amount - $transaction->value;
                $this->walletRepository->update($payerWallet->id, ['amount' => $payerWalletValue]);

                $payeeWalletValue = $payeeWallet->amount + $transaction->value;
                $this->walletRepository->update($payeeWallet->id, ['amount' => $payeeWalletValue]);

                if ($this->paymentAuthorizationService->checkIfIsAuthorized()) {
                    $this->transactionRepository->save($transaction);
                }
            });

            $this->paymentNotificationService->sendNotification();

            return $transaction;
        }catch (QueryException $exception){
            DB::rollBack();
            Log::error($exception->getMessage());
        }

        return $transaction;
    }
}
