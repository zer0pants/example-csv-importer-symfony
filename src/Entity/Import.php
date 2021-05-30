<?php

namespace App\Entity;

use Symfony\Component\HttpFoundation\File\File;

abstract class Import implements IImport
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
