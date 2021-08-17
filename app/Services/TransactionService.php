<?php

namespace App\Services;

use App\Exceptions\CustomHttpException;
use App\Exceptions\TransactionExceptions;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use App\Repositories\WalletRepository;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionService
{
    private const DEFAULT_PAGINATION_NUMBER = 15;

    private TransactionRepository $transactionRepository;
    private WalletRepository $walletRepository;
    private PaymentAuthorizationService $paymentAuthorizationService;
    private PaymentNotificationService $paymentNotificationService;
    private UserRepository $userRepository;

    public function __construct(
        TransactionRepository $transactionRepository,
        WalletRepository $walletRepository,
        PaymentAuthorizationService $paymentAuthorizationService,
        PaymentNotificationService $paymentNotificationService,
        UserRepository $userRepository
    )
    {
        $this->transactionRepository            = $transactionRepository;
        $this->walletRepository                 = $walletRepository;
        $this->paymentAuthorizationService      = $paymentAuthorizationService;
        $this->paymentNotificationService       = $paymentNotificationService;
        $this->userRepository                   = $userRepository;
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
        $value = $data['value'];
        $payerId = $data['payer_id'];
        $payeeId = $data['payee_id'];

        if ($payerId === $payeeId) {
           throw TransactionExceptions::sameUserIdAsPayerAndPayee();
        }

        $user = $this->userRepository->getById($payerId);

        if($user->type === User::USER_TYPE_SHOPKEEPER){
            throw TransactionExceptions::shopkeeperCantMakeATransaction();
        }

        $payerWallet = $this->walletRepository->getByUserId($data['payer_id']);
        $payeeWallet = $this->walletRepository->getByUserId($data['payee_id']);

        if ($value > $payerWallet->amount) {
            throw TransactionExceptions::valueGreaterThanAvailableValueInWallet();
        }

        try {
            DB::beginTransaction();
            DB::transaction(function () use ($value, $payerWallet, $payeeWallet) {
                $payerWalletValue = $payerWallet->amount - $value;
                $this->walletRepository->update($payerWallet->id, ['amount' => $payerWalletValue]);

                $payeeWalletValue = $payeeWallet->amount + $value;
                $payeeWallet->update(['amount' => $payeeWalletValue]);
                $this->walletRepository->update($payeeWallet->id, ['amount' => $payeeWalletValue]);
            });

            if (!$this->paymentAuthorizationService->checkIfIsAuthorized()) {
                throw TransactionExceptions::unauthorizedTransaction();
            }

            $transaction = $this->transactionRepository->store($data);
            $this->paymentNotificationService->sendNotification();

            DB::commit();
        }catch (QueryException $exception){
            DB::rollBack();
            Log::error($exception->getMessage());
        }

        return $transaction;
    }
}
