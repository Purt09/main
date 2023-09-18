<?php

namespace App\Users\Application\Query\FindUserByTelegramId;

use App\Shared\Application\Query\QueryInterface;

class FindUserByTelegramIdQuery implements QueryInterface
{
    public function __construct(public readonly int $telegram_id)
    {
    }
}