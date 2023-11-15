<?php

namespace App\Tokens\Application\Command\AuthBotUser;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Tokens\Application\DTO\AuthTokenDto;
use App\Tokens\Domain\Factory\RefreshBotUserTokenFactory;
use App\Tokens\Domain\Repository\RefreshBotUserTokenRepositoryInterface;
use App\Tokens\Domain\Service\JwtTokenCreateService;

class AuthBotUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly RefreshBotUserTokenRepositoryInterface $tokenRepository,
        private readonly RefreshBotUserTokenFactory $tokenFactory,
        private readonly JwtTokenCreateService $jwtTokenCreateService,
    ) {
    }

    public function __invoke(AuthBotUserCommand $authBotUserCommand): AuthTokenDto
    {
        $token = $this->tokenFactory->create(
            $authBotUserCommand->user_id,
            $authBotUserCommand->bot_id,
            $authBotUserCommand->ip,
            $authBotUserCommand->user_agent,
        );
        $this->tokenRepository->add($token);

        $jwt = $this->jwtTokenCreateService->create($token->getUserId());

        $authDto = new AuthTokenDto();
        $authDto->token = $token->getToken();
        $authDto->jwt = $jwt;

        return $authDto;
    }
}
