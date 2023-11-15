<?php

namespace App\Tests\Functional\Tokens\Domain\Service;

use App\Core\Exception\LogicException;
use App\Tests\Resource\Fixture\RefreshBotUserTokenFixture;
use App\Tests\Tools\FakerTools;
use App\Tokens\Domain\Service\RefreshTokenService;
use App\Tokens\Infrastructure\Repository\RefreshBotUserTokenRepository;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RefreshTokenServiceTest extends WebTestCase
{
    use FakerTools;
    private RefreshBotUserTokenRepository $tokenRepository;
    private RefreshTokenService $refreshService;
    private AbstractDatabaseTool $databaseTool;

    public function setUp(): void
    {
        parent::setUp();
        $this->tokenRepository = $this::getContainer()->get(RefreshBotUserTokenRepository::class);
        $this->refreshService = $this::getContainer()->get(RefreshTokenService::class);
        $this->databaseTool = $this::getContainer()->get(DatabaseToolCollection::class)->get();
    }

    public function testSuccess()
    {
        $executor = $this->databaseTool->loadFixtures([RefreshBotUserTokenFixture::class]);
        $tokenOld = $executor->getReferenceRepository()->getReference(RefreshBotUserTokenFixture::REFERENCE);

        $tokenNew = $this->refreshService->refresh(
            $tokenOld->getToken(),
            $ipNew = $this->getFaker()->ipv4(),
            $userAgentNew = $this->getFaker()->userAgent(),
        );

        $tokenOld = $this->tokenRepository->findByToken($tokenOld->getToken());
        self::assertNotNull($tokenOld->getRefreshAt());
        self::assertNull($tokenNew->getRefreshAt());
        self::assertEquals(mb_strlen($tokenNew->getToken()), 64);
        self::assertNotEquals($tokenOld->getToken(), $tokenNew->getToken());
        self::assertEquals(mb_strlen($tokenNew->getId()), 26);
        self::assertEquals($ipNew, $tokenNew->getIp());
        self::assertEquals($userAgentNew, $tokenNew->getUserAgent());
        self::assertNotNull($tokenNew->getCreatedAt());
        self::assertNull($tokenNew->getRefreshAt());
        self::assertEquals($tokenOld->getUserId(), $tokenNew->getUserId());
    }

    public function testTimeOut()
    {
        $executor = $this->databaseTool->loadFixtures([RefreshBotUserTokenFixture::class]);
        $tokenOld = $executor->getReferenceRepository()->getReference(RefreshBotUserTokenFixture::REFERENCE_TIME_OUT);

        try {
            $tokenNew = $this->refreshService->refresh(
                $tokenOld->getToken(),
                $ipNew = $this->getFaker()->ipv4(),
                $userAgentNew = $this->getFaker()->userAgent(),
            );
            self::assertEquals(1, 2);
        } catch (LogicException $e) {
            self::assertEquals($e->getMessage(), 'token refresh time out');
        }
    }

    public function testRefresh()
    {
        $executor = $this->databaseTool->loadFixtures([RefreshBotUserTokenFixture::class]);
        $tokenOld = $executor->getReferenceRepository()->getReference(RefreshBotUserTokenFixture::REFERENCE_REFRESH);

        try {
            $tokenNew = $this->refreshService->refresh(
                $tokenOld->getToken(),
                $ipNew = $this->getFaker()->ipv4(),
                $userAgentNew = $this->getFaker()->userAgent(),
            );
            self::assertEquals(1, 2);
        } catch (LogicException $e) {
            self::assertEquals($e->getMessage(), 'token already refresh');
        }
    }
}
