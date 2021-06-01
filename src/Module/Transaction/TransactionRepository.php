<?php

namespace App\Module\Transaction;

use App\Module\Transaction\Transaction;

class TransactionRepository
{
    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public static function sortTransactionByDate(Transaction $a, Transaction $b)
    {
        $dateA = $a->getDate()->getTimestamp();
        $dateB = $b->getDate()->getTimestamp();

        return $dateA <=> $dateB;
    }
}
