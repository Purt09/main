<?php
//
//namespace App\Tests\Functional\Users\Application\Query\FindUserByTelegramId;
//
//use App\Shared\Application\Query\QueryBusInterface;
//use App\Tests\Resource\Fixture\UserFixture;
//use App\Users\Application\DTO\UserDTO;
//use App\Users\Application\Query\FindUserByTelegramId\FindUserByTelegramIdQuery;
//use App\Users\Domain\Entity\User;
//use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
//use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
//use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
//
//class FindUserByTelegramIdQueryHandlerTest extends WebTestCase
//{
//    private QueryBusInterface $queryBus;
//    private AbstractDatabaseTool $databaseTool;
//
//    public function setUp(): void
//    {
//        parent::setUp();
//        $this->queryBus = $this::getContainer()->get(QueryBusInterface::class);
//        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class);
//    }
//
//    public function testUserCreatedWhenCommandExecuted(): void
//    {
//        // arrange
//        $referenceRepository = $this->databaseTool->loadFixtures([UserFixture::class])->getReferenceRepository();
//        /** @var User $user */
//        $user = $referenceRepository->getReference(UserFixture::REFERENCE);
//        $query = new FindUserByTelegramIdQuery($user->getTelegramId());
//
//        // act
//        $userDTO = $this->queryBus->execute($query);
//
//        // assert
//        $this->assertInstanceOf(UserDTO::class, $userDTO);
//    }
//}
