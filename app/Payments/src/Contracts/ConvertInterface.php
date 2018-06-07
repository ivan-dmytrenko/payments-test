<?php
namespace App\Payments\Contracts;

interface ConvertInterface
{
    public function convert(string $currencyCode, string $amount);
}