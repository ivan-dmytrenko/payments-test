<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionStoreRequest;
use App\Jobs\ProcessTransactions;
use App\Payments\Contracts\ChargeInterface;
use App\Payments\Exceptions\NotEnoughMoneyException;
use Symfony\Component\HttpFoundation\JsonResponse;

class TransactionController extends Controller
{
    public function store(TransactionStoreRequest $request, ChargeInterface $payment)
    {
        try {
            $payment->preparePayment(
                $request->get('currency_code'),
                $request->get('name_from'),
                $request->get('amount'),
                $request->get('name_to')
            );
            $payment->processChargePayment();
        } catch (NotEnoughMoneyException $e) {
            return response()->json('Not enough money for current transaction.', JsonResponse::HTTP_PRECONDITION_FAILED);
        }

        ProcessTransactions::dispatch($payment)
            ->onConnection('rabbitmq')
            ->onQueue('transactions');

        return response()->json('', JsonResponse::HTTP_CREATED);
    }
}
