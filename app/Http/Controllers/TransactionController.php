<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transaction\TransactionStoreRequest;
use App\Services\TransactionService;
use Illuminate\Http\Response;

class TransactionController extends Controller
{
    private TransactionService $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function index()
    {
        $transactions = $this->transactionService->getAllPaginated();
        return response()->json($transactions, Response::HTTP_OK);
    }

    public function store(TransactionStoreRequest $request)
    {
        $data = $request->validated();

        $transaction = $this->transactionService->store(array_merge(
            $data, ['payer_id' => auth()->user()->id]
        ));

        return response()->json($transaction, Response::HTTP_CREATED);
    }

    public function show(int $id)
    {
        $transaction = $this->transactionService->getById($id);
        return response()->json($transaction, Response::HTTP_OK);
    }

}
