<?php

namespace App\Core\Exception;

class AuthException extends LogicException
{
    protected $code = 401;
}
