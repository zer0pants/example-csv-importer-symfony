<?php

namespace App\Module\Verify;

interface Verifiable
{
    public function verify(): bool;
    public function verified(): bool;
}
