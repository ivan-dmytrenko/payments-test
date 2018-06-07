<?php
namespace App\Validators;

use App\Repositories\Contracts\UserWalletRepositoryInterface;
use Illuminate\Validation\Validator;

class TransactionValidator extends Validator
{
    protected $userWalletRepo;

    public function __construct(
        $translator,
        array $data,
        array $rules,
        array $messages,
        array $customAttributes,
        UserWalletRepositoryInterface $userWalletRepo
    )
    {
        $this->userWalletRepo = $userWalletRepo;
        parent::__construct($translator, $data, $rules, $messages, $customAttributes);
    }

    public function validateAvailableCurrencyCodeToSend($attr, $value)
    {
        $userWallet = $this->userWalletRepo->whereWhereIn(
            [['currency_code', $value]],
            'name',
            [$this->data['name_from'] ?? '' , $this->data['name_to'] ?? '']
        )->first();

        return !is_null($userWallet);
    }

    public function validateReceiverIsNotSender($attr, $value)
    {
        return $value !== $this->data['name_from'];
    }
}