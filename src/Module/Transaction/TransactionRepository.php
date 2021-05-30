<?php

namespace App\Module\Transaction;

use App\Module\Transaction\ITransaction;

class TransactionRepository
{
    protected $transaction;

    public function __construct(ITransaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public static function sortTransactionByDate(ITransaction $a, ITransaction $b)
    {
        $dateA = strtotime($a->getDate());
        $dateB = strtotime($b->getDate());

        return $dateA <=> $dateB;
    }
}
