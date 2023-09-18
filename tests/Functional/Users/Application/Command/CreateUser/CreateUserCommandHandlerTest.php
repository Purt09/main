<?php
//
//namespace App\Tests\Functional\Users\Application\Command\CreateUser;
//
//use App\Shared\Application\Command\CommandBusInterface;
//use App\Tests\Tools\FakerTools;
//use App\Users\Application\Command\CreateUser\CreateUserCommand;
//use App\Users\Domain\Entity\UserType;
//use App\Users\Domain\Repository\UserRepositoryInterface;
//use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
//
//class CreateUserCommandHandlerTest extends WebTestCase
//{
//    use FakerTools;
//
//    private CommandBusInterface $commandBus;
//
//    /**
//     * @var UserRepositoryInterface
//     */
//    private UserRepositoryInterface $userRepository;
//
//    /**
//     * @throws \Exception
//     */
//    public function setUp(): void
//    {
//        parent::setUp();
//        $this->commandBus = $this::getContainer()->get(CommandBusInterface::class);
//        $this->userRepository = $this::getContainer()->get(UserRepositoryInterface::class);
//    }
//
//    public function testUserCreatedSuccessfully(): void
//    {
//        $tg_id = $this->getFaker()->randomNumber();
//        $first_name = $this->getFaker()->word();
//        $last_name = $this->getFaker()->word();
//        $username = $this->getFaker()->word();
//        $type = $this->getFaker()->randomElement([
//            UserType::PRIVATE,
//            UserType::GROUP,
//            UserType::SUPERGROUP,
//            UserType::CHANNEL,
//        ]);
//        $command = new CreateUserCommand($tg_id, $first_name, $last_name, $username, $type);
//
//        // act
//        $id = $this->commandBus->execute($command);
//
//        // assert
//        $user = $this->userRepository->findById($id);
//        $this->assertNotEmpty($user);
//    }
//}