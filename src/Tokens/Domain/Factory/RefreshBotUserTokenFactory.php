<?php

namespace App\Tokens\Domain\Factory;

use App\Shared\Domain\Service\StringService;
use App\Tokens\Domain\Entity\RefreshBotUserToken;

class RefreshBotUserTokenFactory
{
    public function create(
        int $user_id,
        int $bot_id,
        string $ip,
        string $user_agent,
        int $created_at = null
    ): RefreshBotUserToken {
        $token = new RefreshBotUserToken(
            StringService::generateString(null, 64),
            $user_id,
            $ip,
            $bot_id,
            $user_agent,
            $created_at
        );

        return $token;
    }
}
