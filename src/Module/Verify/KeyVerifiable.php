<?php

namespace App\Module\Verify;

interface KeyVerifiable extends Verifiable
{
    public function getVerifiableKey(): string;
    public function setKeyVerification(KeyVerification $verification): void;
}
