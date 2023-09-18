<?php

namespace App\Tokens\Domain\Factory;

use App\Shared\Domain\Service\StringService;
use App\Tokens\Domain\Entity\RefreshBotUserToken;
use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

class RefreshBotUserTokenFactory
{
    public function create(
        int     $user_id,
        string $ip,
    ): RefreshBotUserToken
    {
        $refresh_at = time() + 24 * 60 * 60;
        $token = new RefreshBotUserToken(
            $refresh_at,
            StringService::generateString(null, 64),
            $user_id,
            $ip
        );
        return $token;
    }
}