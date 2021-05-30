<?php

use App\Module\Transaction\ITransaction;

namespace App\Module\Transaction;

abstract class ATransaction implements ITransaction
{
    protected $date;
    protected $transactionCode;
    protected $customerNumber;
    protected $reference;
    protected $amount;
    protected $type;
    protected $valid;

    public function getDate(): string
    {
        return $this->date;
    }

    public function getTransactionCode(): string
    {
        return $this->transactionCode;
    }

    public function getCustomerNumber(): int
    {
        return $this->customerNumber;
    }

    public function getReference(): string
    {
        return $this->reference;
    }

    public function getAmount(): float
    {
        return $this->amount / 100;
    }

    public function getValid(): bool
    {
        return $this->valid;
    }
}
