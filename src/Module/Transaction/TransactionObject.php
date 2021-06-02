<?php

namespace App\Module\Transaction;

use App\Module\Verify\KeyVerifiable;
use App\Module\Verify\KeyVerification;

use DateTime;

class TransactionObject implements Transaction, KeyVerifiable
{
    protected $date;
    protected $transactionCode;
    protected $customerNumber;
    protected $reference;
    protected $amount;
    protected $type;
    protected $valid = false;
    protected $verification;

    public function __construct(DateTime $date, string $transactionCode, int $customerNumber, string $reference, int $amount)
    {
        $this->date = $date;
        $this->transactionCode = $transactionCode;
        $this->customerNumber = $customerNumber;
        $this->reference = $reference;
        $this->amount = $amount;
    }

    public function getType(): string
    {
        return $this->type ?? $this->type = $this->amount < 0 ? 'debit' : 'credit';
    }

    public function getKey(): string
    {
        return $this->transactionCode;
    }

    public function getDate(): DateTime
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

    public function setKeyVerification(KeyVerification $verification): void
    {
        $this->verification = $verification;
    }

    public function verify(): bool
    {
        $this->valid = $this->verification->check($this);

        return $this->verified();
    }

    public function verified(): bool
    {
        return $this->valid;
    }

    public function setValid($valid)
    {
        $this->valid = $valid;
    }

    public function getVerifiableKey(): string
    {
        return $this->transactionCode;
    }
}
