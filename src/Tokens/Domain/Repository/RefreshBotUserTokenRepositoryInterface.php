<?php

namespace App\Tokens\Domain\Repository;

use App\Tokens\Domain\Entity\RefreshBotUserToken;

interface RefreshBotUserTokenRepositoryInterface
{
    public function save(RefreshBotUserToken $token): void;

    public function add(RefreshBotUserToken $token): void;

    public function remove(RefreshBotUserToken $token): void;

    public function findByToken(string $token): ?RefreshBotUserToken;
}
