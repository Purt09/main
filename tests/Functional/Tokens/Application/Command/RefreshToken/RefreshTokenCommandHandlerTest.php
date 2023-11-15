<?php

namespace App\Tests\Functional\Tokens\Application\Command\RefreshToken;

use App\Shared\Application\Command\CommandBusInterface;
use App\Tests\Resource\Fixture\RefreshBotUserTokenFixture;
use App\Tests\Tools\FakerTools;
use App\Tokens\Application\Command\RefreshToken\RefreshTokenCommand;
use App\Tokens\Application\DTO\AuthTokenDto;
use App\Tokens\Domain\Entity\RefreshBotUserToken;
use App\Tokens\Infrastructure\Repository\RefreshBotUserTokenRepository;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RefreshTokenCommandHandlerTest extends WebTestCase
{
    use FakerTools;
    private CommandBusInterface $commandBus;
    private RefreshBotUserTokenRepository $tokenRepository;
    private AbstractDatabaseTool $databaseTool;

    public function setUp(): void
    {
        parent::setUp();
        $this->commandBus = $this::getContainer()->get(CommandBusInterface::class);
        $this->tokenRepository = $this::getContainer()->get(RefreshBotUserTokenRepository::class);
        $this->databaseTool = $this::getContainer()->get(DatabaseToolCollection::class)->get();
    }

    public function testSuccess()
    {
        $executor = $this->databaseTool->loadFixtures([RefreshBotUserTokenFixture::class]);
        /** @var RefreshBotUserToken $token */
        $token = $executor->getReferenceRepository()->getReference(RefreshBotUserTokenFixture::REFERENCE);
        $command = new RefreshTokenCommand(
            $token->getToken(),
            $ip = $token->getIp(),
            $userAgent = $this->getFaker()->userAgent(),
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
        $tokenNew = $this->tokenRepository->findByToken($dto->token);
        /** @var RefreshBotUserToken $tokenNew */
        /** @var RefreshBotUserToken $tokenOld */
        $tokenOld = $this->tokenRepository->findByToken($token->getToken());
        self::assertNull($tokenNew->getRefreshAt());
        self::assertEquals($ip, $tokenNew->getIp());
        self::assertEquals($userAgent, $tokenNew->getUserAgent());
        self::assertNull($tokenNew->getRefreshAt());
        self::assertEquals($token->getUserId(), $tokenOld->getUserId());
        self::assertEquals($token->getBotId(), $tokenOld->getBotId());
    }
}
