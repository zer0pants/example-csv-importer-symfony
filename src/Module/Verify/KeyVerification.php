<?php

namespace App\Module\Verify;

interface KeyVerification
{
    public function check(KeyVerifiable $verifiable): bool;
}
