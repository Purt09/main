<?php

namespace App\Tokens\Application\Helper;

use App\Tokens\Domain\Entity\BotUserRole;

class BotUserRoleHelper
{
    /**
     * Определяет по статусу роль пользователя.
     */
    public static function getRole(int $status): string
    {
        $statuses = [
            1 => BotUserRole::USER,
            2 => BotUserRole::USER_NOT_ACTIVE,
            3 => BotUserRole::BAN,
            4 => BotUserRole::MANAGER,
            5 => BotUserRole::NO_VERIFICATION,
            6 => BotUserRole::PROTECTION,
            7 => BotUserRole::ADMIN,
        ];
        if (!array_key_exists($status, $statuses)) {
            throw new \RuntimeException('not valid status');
        }

        return $statuses[$status];
    }
}
