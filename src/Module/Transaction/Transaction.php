<?php

namespace App\Module\Transaction;

use DateTime;

interface Transaction
{
    // TODO - how might a transactions behaviour change?
    public function getType(): string;
    public function getDate(): DateTime;
    public function getAmount(): float;
    public function getTransactionCode(): string;
}
