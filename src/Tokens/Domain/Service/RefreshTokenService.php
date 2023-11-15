<?php

namespace App\Tokens\Domain\Service;

use App\Core\Exception\LogicException;
use App\Tokens\Domain\Entity\RefreshBotUserToken;
use App\Tokens\Domain\Factory\RefreshBotUserTokenFactory;
use App\Tokens\Domain\Repository\RefreshBotUserTokenRepositoryInterface;

/**
 * Сервис обновления токена.
 */
class RefreshTokenService
{
    public function __construct(
        private readonly RefreshBotUserTokenRepositoryInterface $tokenRepository,
        private readonly RefreshBotUserTokenFactory $tokenFactory
    ) {
    }

    public function refresh(string $token, string $ip, string $user_agent): RefreshBotUserToken
    {
        $tokenOld = $this->tokenRepository->findByToken(
            $token
        );
        if ($tokenOld->getCreatedAt() < time() - intval($_ENV['REFRESH_TOKEN_DAYS_LIFE']) * 24 * 60 * 60) {
            throw new LogicException('token refresh time out');
        }
        if (!is_null($tokenOld->getRefreshAt())) {
            throw new LogicException('token already refresh');
        }
        $tokenOld->setRefreshAt(time());
        $this->tokenRepository->save($tokenOld);
        $tokenNew = $this->tokenFactory->create(
            $tokenOld->getUserId(),
            $tokenOld->getBotId(),
            $ip,
            $user_agent,
        );
        $this->tokenRepository->add($tokenNew);

        return $tokenNew;
    }
}
