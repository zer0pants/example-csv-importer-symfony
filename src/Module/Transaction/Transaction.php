<?php

namespace App\Module\Transaction;

class Transaction extends ATransaction implements ITransaction
{
    protected $verificationHandler;

    public function __construct(string $date, string $transactionCode, int $customerNumber, string $reference, int $amount, IVerify $verficationHandler)
    {
        $this->date = $date;
        $this->transactionCode = $transactionCode;
        $this->customerNumber = $customerNumber;
        $this->reference = $reference;
        $this->amount = $amount;
        $this->verificationHandler = $verficationHandler;

        $this->valid = $this->verify();
        $this->type = $this->getType();
    }

    public function verify(): bool
    {
        return $this->verificationHandler->verify($this);
    }

    public function getType(): string
    {
        return $this->amount < 0 ? 'debit' : 'credit';
    }

    public function getKey(): string
    {
        return $this->transactionCode;
    }
}
