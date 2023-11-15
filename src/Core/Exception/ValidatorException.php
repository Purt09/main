<?php

namespace App\Core\Exception;

class ValidatorException extends LogicException
{
    protected $code = 400;
}
