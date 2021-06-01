<?php

namespace App\Module\Transaction;

use App\Module\Verify\KeyVerifiable;
use App\Module\Verify\KeyVerification;
use App\Module\Verify\Verifiable;
use App\Module\Verify\VerificationHandler;

class TransactionVerificationHandler implements VerificationHandler
{
    protected $transaction;
    protected $verification;

    public function setObject(KeyVerifiable $object): void
    {
        $this->transaction = $object;
    }

    public function setVerification(KeyVerification $verification): void
    {
        $this->verification = $verification;
    }

    public function handle(): bool
    {
        return $this->verification->check($this->transaction);
    }
}
