<?php
//
//namespace App\Tests\Functional\Users\Infrastructure\Repository;
//
//use App\Tests\Resource\Fixture\UserFixture;
//use App\Users\Domain\Entity\UserType;
//use App\Users\Domain\Factory\UserFactory;
//use App\Users\Domain\Repository\UserRepositoryInterface;
//use App\Users\Infrastructure\Repository\UserRepository;
//use Faker\Factory;
//use Faker\Generator;
//use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
//use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
//use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
//
//class UserRepositoryTest extends WebTestCase
//{
//    private UserRepository $repository;
//    private Generator $faker;
//
//    private AbstractDatabaseTool $databaseTool;
//    public function setUp(): void
//    {
//        parent::setUp();
//        $this->repository = static::getContainer()->get(UserRepository::class);
//        $this->faker = Factory::create();
//        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
//    }
//
//    public function testUserAddedSuccessfully()
//    {
//        $tg_id = $this->faker->randomNumber();
//        $first_name = $this->faker->word();
//        $last_name = $this->faker->word();
//        $username = $this->faker->word();
//        $type = $this->faker->randomElement([
//            UserType::PRIVATE,
//            UserType::GROUP,
//            UserType::SUPERGROUP,
//            UserType::CHANNEL,
//        ]);
//        $user = (new UserFactory())->create($tg_id, $first_name, $last_name, $username, $type);
//
//        // act
//        $this->repository->add($user);
//
//        // assert
//        $userNew = $this->repository->findByTelegramId($user->getTelegramId());
//
//        $this->assertEquals($user->getId(), $userNew->getId());
//    }
//
//    public function testUserFoundSuccessfully()
//    {
//        // arrange
//        $executor = $this->databaseTool->loadFixtures([UserFixture::class]);
//        $user = $executor->getReferenceRepository()->getReference(UserFixture::REFERENCE);
//
//        // act
//        $existingUser = $this->repository->findById($user->getId());
//
//        // assert
//        $this->assertEquals($existingUser->getId(), $user->getId());
//    }
//}
