<?php

namespace App\Libraries;

class NXPath
{
    private $value;
    function __construct($value)
    {
        $this->value = $value;
    }
    function getValue()
    {
        return $this->value;
    }
}
