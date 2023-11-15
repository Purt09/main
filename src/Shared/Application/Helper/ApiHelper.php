<?php

namespace App\Shared\Application\Helper;

use App\Core\Exception\LogicException;

class ApiHelper
{
    public static function success(mixed $message): array
    {
        return [
            'ok' => true,
            'status' => 200,
            'result' => $message,
        ];
    }

    public static function error(LogicException $e): array
    {
        return [
            'ok' => false,
            'title' => $e->getMessage(),
            'status' => $e->getCode(),
            'detail' => $e->getDetail(),
            'type' => $e->getHelp(),
        ];
    }

    public static function errorServer(\Throwable $e): array
    {
        return [
            'ok' => false,
            'title' => $e->getMessage(),
            'status' => $e->getCode(),
            'detail' => null,
            'type' => null,
        ];
    }
}
