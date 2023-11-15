<?php

namespace App\Tests\Functional\Tokens\Infrastructure\Controller;

use App\Tests\Resource\Fixture\RefreshBotUserTokenFixture;
use App\Tokens\Domain\Entity\RefreshBotUserToken;
use App\Tokens\Infrastructure\Repository\RefreshBotUserTokenRepository;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthBotUserActionTest extends WebTestCase
{
    private RefreshBotUserTokenRepository $repository;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = static::getContainer()->get(RefreshBotUserTokenRepository::class);
        $this->databaseTool = $this::getContainer()->get(DatabaseToolCollection::class)->get();
    }

    public function testAuthBotUser(): void
    {
        self::ensureKernelShutdown();
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/v1/auth-user-work',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'bot_id' => $bot_id = 886,
                'data' => 'query_id=AAHql5h_AAAAAOqXmH_Yjo2U&user=%7B%22id%22%3A2140706794%2C%22first_name%22%3A%22BOT-T%22%2C%22last_name%22%3A%22%28%D0%A2%D0%B5%D1%85%D0%BD%D0%B8%D1%87%D0%B5%D1%81%D0%BA%D0%B0%D1%8F%20%D0%BF%D0%BE%D0%B4%D0%B4%D0%B5%D1%80%D0%B6%D0%BA%D0%B0%29%22%2C%22username%22%3A%22BOTTRU%22%2C%22language_code%22%3A%22ru%22%2C%22is_premium%22%3Atrue%2C%22allows_write_to_pm%22%3Atrue%7D&auth_date=1697970909&hash=603ac3d767a733568266bd74e4e9f0b35d8fc37b48d5ec62c04d97a2cb98af8e',
            ])
        );

        $jsonResult = $client->getResponse()->getContent();
        $data = json_decode($jsonResult, true);
        $this->assertEquals($data['status'], 200);
        $this->assertArrayHasKey('jwt', $data['result']);
        $this->assertArrayHasKey('token', $data['result']);

        $token = $this->repository->findByToken($data['result']['token']);
        $this->assertNotNull($token);
        $this->assertNull($token->getRefreshAt());
        $this->assertEquals($token->getBotId(), $bot_id);
        $this->assertEquals($token->getUserAgent(), 'Symfony BrowserKit');
        $this->assertEquals($token->getIp(), '127.0.0.1');
    }

    public function testRefresh(): void
    {
        $executor = $this->databaseTool->loadFixtures([RefreshBotUserTokenFixture::class]);
        /** @var RefreshBotUserToken $token */
        $token = $executor->getReferenceRepository()->getReference(RefreshBotUserTokenFixture::REFERENCE);

        self::ensureKernelShutdown();
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/v1/refresh',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'token' => $token->getToken(),
            ])
        );

        $jsonResult = $client->getResponse()->getContent();
        $data = json_decode($jsonResult, true);

        $this->assertEquals($data['status'], 200);
        $this->assertArrayHasKey('jwt', $data['result']);
        $this->assertArrayHasKey('token', $data['result']);
        $tokenOld = $this->repository->findByToken($token->getToken());
        $this->assertNotNull($tokenOld);
        $this->assertNotNull($tokenOld->getRefreshAt());
        $tokenNew = $this->repository->findByToken($data['result']['token']);
        $this->assertNotNull($tokenNew);
        $this->assertNull($tokenNew->getRefreshAt());
        $this->assertEquals($tokenNew->getBotId(), $tokenOld->getBotId());
    }

    public function testRefreshOldToken()
    {
        $executor = $this->databaseTool->loadFixtures([RefreshBotUserTokenFixture::class]);
        $tokenOld = $executor->getReferenceRepository()->getReference(RefreshBotUserTokenFixture::REFERENCE_TIME_OUT);

        self::ensureKernelShutdown();
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/v1/refresh',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'token' => $tokenOld->getToken(),
            ])
        );

        $jsonResult = $client->getResponse()->getContent();
        $data = json_decode($jsonResult, true);

        $this->assertEquals($data['status'], 400);
        $this->assertEquals($data['title'], 'token refresh time out');
    }
}
