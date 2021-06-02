<?php

namespace App\Module\Transaction;

use DateTime;

interface Transaction
{
    public function getType(): string;
    public function getDate(): DateTime;
    public function getAmount(): float;
    public function getTransactionCode(): string;
}
