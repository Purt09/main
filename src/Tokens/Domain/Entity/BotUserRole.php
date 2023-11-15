<?php

namespace App\Tokens\Domain\Entity;

class BotUserRole
{
    public const USER = 'user';
    public const USER_NOT_ACTIVE = 'not_active';
    public const ADMIN = 'admin';
    public const MANAGER = 'manager';
    public const BAN = 'ban';
    public const PROTECTION = 'protection';
    public const NO_VERIFICATION = 'no_verification';
}
