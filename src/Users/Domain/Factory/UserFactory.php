<?php

namespace App\Users\Domain\Factory;

use App\Shared\Domain\Service\StringService;
use App\Users\Domain\Entity\User;

class UserFactory
{
    public function create(
        int     $tg_id,
        ?string $first_name,
        ?string $last_name,
        ?string $username,
        int     $type,
    ): User
    {
        $user = new User($tg_id, $first_name, $last_name, $username, $type);
        $user->setVerificationToken(StringService::generateString(null, 64));
        $user->setAuthKey(StringService::generateString(null, 32));
        return $user;
    }
}