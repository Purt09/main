<?php

namespace App\Users\Application\Command\CreateUser;

class CreateUserCommand
{
    public function __construct(
        public readonly int $tg_id,
        public readonly ?string $first_name,
        public readonly ?string $last_name,
        public readonly ?string $username,
        public readonly int     $type,
    )
    {

    }
}