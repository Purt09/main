<?php

namespace App\Tokens\Application\Command\RefreshToken;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Tokens\Application\DTO\AuthTokenDto;
use App\Tokens\Domain\Repository\RefreshBotUserTokenRepositoryInterface;
use App\Tokens\Domain\Service\JwtTokenCreateService;
use App\Tokens\Domain\Service\RefreshTokenService;

class RefreshTokenCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly RefreshBotUserTokenRepositoryInterface $tokenRepository,
        private readonly RefreshTokenService $refreshTokenService,
        private readonly JwtTokenCreateService $jwtTokenCreateService,
    ) {
    }

    public function __invoke(RefreshTokenCommand $refreshTokenCommand): AuthTokenDto
    {
        $token = $this->tokenRepository->findByToken(
            $refreshTokenCommand->token
        );

        $tokenNew = $this->refreshTokenService->refresh(
            $token->getToken(),
            $refreshTokenCommand->ip,
            $refreshTokenCommand->user_agent
        );
        $jwt = $this->jwtTokenCreateService->create($tokenNew->getUserId());

        $authDto = new AuthTokenDto();
        $authDto->token = $tokenNew->getToken();
        $authDto->jwt = $jwt;

        return $authDto;
    }
}
