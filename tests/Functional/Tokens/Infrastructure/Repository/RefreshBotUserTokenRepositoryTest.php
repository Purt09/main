<?php

namespace App\Tests\Functional\Tokens\Infrastructure\Repository;

use App\Tests\Resource\Fixture\RefreshBotUserTokenFixture;
use App\Tests\Tools\FakerTools;
use App\Tokens\Domain\Factory\RefreshBotUserTokenFactory;
use App\Tokens\Infrastructure\Repository\RefreshBotUserTokenRepository;
use Faker\Generator;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RefreshBotUserTokenRepositoryTest extends WebTestCase
{
    use FakerTools;
    private RefreshBotUserTokenRepository $repository;
    private Generator $faker;

    private AbstractDatabaseTool $databaseTool;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = static::getContainer()->get(RefreshBotUserTokenRepository::class);
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
    }

    public function testUserAddedSuccessfully()
    {
        $user_id = $this->getFaker()->randomNumber();
        $bot_id = $this->getFaker()->randomNumber();
        $ip = $this->getFaker()->ipv6();
        $userAgent = $this->getFaker()->userAgent();
        $token = (new RefreshBotUserTokenFactory())->create($user_id, $bot_id, $ip, $userAgent);

        // act
        $this->repository->add($token);

        // assert
        $tokenNew = $this->repository->findByToken($token->getToken());

        $this->assertEquals($token->getId(), $tokenNew->getId());
    }

    public function testUserRemovedSuccessfully()
    {
        $user_id = $this->getFaker()->randomNumber();
        $bot_id = $this->getFaker()->randomNumber();
        $ip = $this->getFaker()->ipv6();
        $userAgent = $this->getFaker()->userAgent();
        $token = (new RefreshBotUserTokenFactory())->create($user_id, $bot_id, $ip, $userAgent);

        // act
        $this->repository->add($token);
        $this->repository->remove($token);

        // assert
        $tokenNew = $this->repository->findByToken($token->getToken());

        $this->assertNull($tokenNew);
    }

    public function testFindByToken()
    {
        // arrange
        $executor = $this->databaseTool->loadFixtures([RefreshBotUserTokenFixture::class]);
        $token = $executor->getReferenceRepository()->getReference(RefreshBotUserTokenFixture::REFERENCE);

        // act
        $tokenNew = $this->repository->findByToken($token->getToken());

        // assert
        $this->assertEquals($token->getId(), $tokenNew->getId());
    }
}
