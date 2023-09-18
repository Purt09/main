<?php

namespace App\Users\Domain\Entity;

class UserType
{
    public const PRIVATE = 1;
    public const GROUP = 2;
    public const SUPERGROUP = 3;
    public const CHANNEL = 4;
    private int $id;
    private string $type;
}
