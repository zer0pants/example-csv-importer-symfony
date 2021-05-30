<?php

namespace App\Module\Transaction;

interface IVerify
{
    public function verify(ITransaction $transaction): bool;
}
