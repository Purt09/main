<?php

namespace App\Tests\Functional\Tokens\Application\Command\AuthBotUser;

use App\Shared\Application\Command\CommandBusInterface;
use App\Tests\Tools\FakerTools;
use App\Tokens\Application\Command\AuthBotUser\AuthBotUserCommand;
use App\Tokens\Application\DTO\AuthTokenDto;
use App\Tokens\Infrastructure\Repository\RefreshBotUserTokenRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthBotUserCommandHandlerTest extends WebTestCase
{
    use FakerTools;
    private CommandBusInterface $commandBus;
    private RefreshBotUserTokenRepository $tokenRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->commandBus = $this::getContainer()->get(CommandBusInterface::class);
        $this->tokenRepository = $this::getContainer()->get(RefreshBotUserTokenRepository::class);
    }

    public function testAuthBotUserSuccess(): void
    {
        $command = new AuthBotUserCommand(
            $user_id = $this->getFaker()->numberBetween(),
            $ip = $this->getFaker()->ipv4(),
            $userAgent = $this->getFaker()->userAgent(),
            $bot_id = $this->getFaker()->numberBetween()
        );

        /** @var AuthTokenDto $dto */
        $dto = $this->commandBus->execute($command);

        list($headersB64, $payloadB64, $sig) = explode('.', $dto->jwt);

        $decoded = json_decode(base64_decode($headersB64), true);
        self::assertArrayHasKey('typ', $decoded);
        self::assertArrayHasKey('alg', $decoded);

        $decoded = json_decode(base64_decode($payloadB64), true);
        self::assertArrayHasKey('iat', $decoded);
        self::assertArrayHasKey('nbf', $decoded);
        self::assertArrayHasKey('exp', $decoded);
        self::assertArrayHasKey('sub', $decoded);
        self::assertArrayHasKey('iss', $decoded);
        self::assertArrayHasKey('aud', $decoded);
        $tokenByBd = $this->tokenRepository->findByToken($dto->token);
        self::assertEquals(mb_strlen($dto->token), 64);
        self::assertEquals($dto->token, $tokenByBd->getToken());
        self::assertEquals(mb_strlen($tokenByBd->getId()), 26);
        self::assertEquals($ip, $tokenByBd->getIp());
        self::assertEquals($userAgent, $tokenByBd->getUserAgent());
        self::assertEquals($bot_id, $tokenByBd->getBotId());
        self::assertNotNull($tokenByBd->getCreatedAt());
        self::assertNull($tokenByBd->getRefreshAt());
        self::assertEquals($user_id, $tokenByBd->getUserId());
    }
}
