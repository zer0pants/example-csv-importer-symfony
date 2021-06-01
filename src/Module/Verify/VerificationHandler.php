<?php

namespace App\Module\Verify;

use App\Interfaces\Handler;

interface VerificationHandler extends Handler
{
    public function handle(): bool;

    public function setObject(KeyVerifiable $object): void;
    public function setVerification(KeyVerification $verification): void;
}
