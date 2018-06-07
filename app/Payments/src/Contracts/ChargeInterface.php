<?php

namespace App\Payments\Contracts;

interface ChargeInterface
{
    public function preparePayment(string $currencyTo, string $senderName, string $amount, string $receiverName);

    public function processChargePayment();

    public function processReceivePayment();

    public function processChargeBackPayment();
}