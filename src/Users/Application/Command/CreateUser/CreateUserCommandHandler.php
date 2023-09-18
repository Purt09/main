<?php

namespace App\Users\Application\Command\CreateUser;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Users\Domain\Factory\UserFactory;
use App\Users\Domain\Repository\UserRepositoryInterface;

class CreateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(private readonly UserRepositoryInterface $userRepository, private readonly UserFactory $userFactory)
    {
    }

    /**
     * @param CreateUserCommand $createUserCommand
     * @return string ID user
     */
    public function __invoke(CreateUserCommand $createUserCommand): string
    {
        $user = $this->userFactory->create(
            $createUserCommand->tg_id,
            $createUserCommand->first_name,
            $createUserCommand->last_name,
            $createUserCommand->username,
            $createUserCommand->type,
        );
        $this->userRepository->add($user);

        return $user->getId();
    }
}