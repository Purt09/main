<?php

namespace App\Tests\Functional\Tokens\Infrastructure\Repository;

use App\Tokens\Domain\Factory\RefreshBotUserTokenFactory;
use App\Tokens\Domain\Repository\RefreshBotUserTokenRepositoryInterface;
use App\Tokens\Infrastructure\Repository\RefreshBotUserTokenRepository;
use Faker\Factory;
use Faker\Generator;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RefreshBotUserTokenRepositoryTest extends WebTestCase
{
    private RefreshBotUserTokenRepositoryInterface $repository;
    private Generator $faker;

    private AbstractDatabaseTool $databaseTool;
    public function setUp(): void
    {
        parent::setUp();
        $this->repository = static::getContainer()->get(RefreshBotUserTokenRepository::class);
        $this->faker = Factory::create();
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
    }

    public function testUserAddedSuccessfully()
    {
        $user_id = $this->faker->randomNumber();
        $ip = $this->faker->ipv6();
        $token = (new RefreshBotUserTokenFactory())->create($user_id, $ip);

        // act
        $this->repository->add($token);

        // assert
        $tokenNew = $this->repository->findByToken($token->getToken());

        $this->assertEquals($token->getId(), $tokenNew->getId());
    }

}
