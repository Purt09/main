<?php

namespace App\Tokens\Domain\Repository;


use App\Tokens\Domain\Entity\RefreshBotUserToken;

interface RefreshBotUserTokenRepositoryInterface
{
    /**
     * Создает токен
     *
     * @param RefreshBotUserToken $user
     * @return void
     */
    public function add(RefreshBotUserToken $user): void;

    /**
     * @param string $token
     * @return RefreshBotUserToken|null
     */
    public function findByToken(string $token): ?RefreshBotUserToken;
}