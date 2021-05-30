<?php

namespace App\Module\Transaction;

interface ITransaction
{
    public function verify(): bool;
    public function getType(): string;
    public function getKey(): string;
    public function getDate(): string;
    public function getAmount(): float;
}
