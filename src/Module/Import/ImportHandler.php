<?php

namespace App\Module\Import;

use App\Interfaces\Handler;

class ImportHandler implements Handler
{
    protected $import;

    public function __construct(Importable $import)
    {
        $this->import = $import;
    }

    public function handle(): array
    {
        return $this->import->import();
    }
}
