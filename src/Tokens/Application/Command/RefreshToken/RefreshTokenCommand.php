<?php

namespace App\Tokens\Application\Command\RefreshToken;

use App\Shared\Application\Command\CommandInterface;

class RefreshTokenCommand implements CommandInterface
{
    public function __construct(
        public readonly string $token,
        public readonly string $ip,
        public readonly string $user_agent,
    ) {
    }
}
