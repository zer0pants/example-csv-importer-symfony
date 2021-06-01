<?php

namespace App\Module\Import;

use Symfony\Component\HttpFoundation\File\File;

abstract class ImportObject implements Importable
{
    protected $object;

    public function __construct(?File $object = null)
    {
        $this->object = $object;
    }

    public function getObject(): ?File
    {
        return $this->object;
    }

    public function setObject(File $object): void
    {
        $this->object = $object;
    }
}
