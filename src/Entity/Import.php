<?php

namespace App\Entity;

use Symfony\Component\HttpFoundation\File\File;

class Import
{
    protected $object;

    public function __construct(?File $object = null)
    {
        $this->object = $object;
    }

    // TODO - return types / docs
    public function getObject(): ?File
    {
        return $this->object;
    }

    public function setObject($object): void
    {
        $this->object = $object;
    }
}
