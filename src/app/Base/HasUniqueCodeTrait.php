<?php

namespace App\Base;

trait HasUniqueCodeTrait
{
    /**
     * @return string|null
     */
    public function getCode() : ?string
    {
        return $this->code;
    }
}