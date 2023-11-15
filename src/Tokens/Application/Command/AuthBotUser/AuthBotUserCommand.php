<?php

namespace App\Tokens\Application\Command\AuthBotUser;

use App\Shared\Application\Command\CommandInterface;

class AuthBotUserCommand implements CommandInterface
{
    public function __construct(
        public readonly int $user_id,
        public readonly string $ip,
        public readonly string $user_agent,
        public readonly int $bot_id,
    ) {
    }
}
