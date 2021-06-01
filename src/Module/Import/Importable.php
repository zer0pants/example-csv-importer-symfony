<?php

namespace App\Module\Import;

interface Importable
{
    public function import(): array;
}
