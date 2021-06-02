<?php

namespace App\Module\Transaction;

use App\Module\Verify\CheckCharacterVerification;
use App\Module\Verify\VerificationHandler;

use DateTime;

class TransactionObjectFactory
{
    protected $verificationHandler;

    public function __construct(VerificationHandler $verificationHandler)
    {
        $this->verificationHandler = $verificationHandler;
    }

    public function create(string $date, string $transactionCode, int $customerNumber, string $reference, int $amount): TransactionObject
    {
        $transaction = new TransactionObject(new DateTime($date), $transactionCode, $customerNumber, $reference, $amount);
        $verification = new CheckCharacterVerification();

        $this->verificationHandler->setObject($transaction);
        $this->verificationHandler->setVerification($verification);

        $verified = $this->verificationHandler->handle();   
        $transaction->setValid($verified);
        
        return $transaction;
    }
}
