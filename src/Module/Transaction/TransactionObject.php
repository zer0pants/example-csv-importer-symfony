<?php

namespace App\Module\Transaction;

use App\Module\Verify\KeyVerifiable;
use App\Module\Verify\KeyVerification;
use App\Module\Verify\CheckCharacterVerification;

use DateTime;


// TODO - CLEAN UP
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
        // $this->verification = $verification;
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

    // TODO - Currency class?
    public function getAmount(): float
    {
        return $this->amount / 100;
    }

    // TODO - refactor based on changes
    public function getValid(): bool
    {
        return $this->valid;
    }

    // TODO - want to get rid of this
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
