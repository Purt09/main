<?php

namespace App\Core\Exception;

class NotAccessException extends LogicException
{
    protected $code = 403;
}
