<?php

namespace App\Module\Import;

use App\Entity\IImport;

class ImportHandler implements IHandler
{
    protected $import;

    public function __construct(IImport $import)
    {
        $this->import = $import;
    }

    public function handle(): array
    {
        return $this->import->import();
    }
}
