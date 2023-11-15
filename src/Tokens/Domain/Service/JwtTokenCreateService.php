<?php

namespace App\Tokens\Domain\Service;

use Firebase\JWT\JWT;

class JwtTokenCreateService
{
    public function create(int $user_id): string
    {
        $privateKeyFile = __DIR__.'/../../../../config/jwt/private.rem';

        // Create a private key of type "resource"
        $privateKey = file_get_contents($privateKeyFile);
        $payload = [
            'iat' => time(),
            'nbf' => time(),
            'exp' => time() + 60 * intval($_ENV['JWT_MINUTES_LIFE']),
            'sub' => $user_id,
            'iss' => 'BOT-T AUTH',
            'aud' => 'BOT-T',
        ];

        return JWT::encode($payload, $privateKey, 'RS256');
    }
}
