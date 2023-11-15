<?php

namespace App\Core\Exception;

class NotFoundException extends LogicException
{
    protected $code = 400;
}
