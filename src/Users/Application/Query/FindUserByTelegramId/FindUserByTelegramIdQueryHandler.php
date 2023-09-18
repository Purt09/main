<?php

namespace App\Users\Application\Query\FindUserByTelegramId;

use App\Users\Application\DTO\UserDTO;
use App\Users\Domain\Repository\UserRepositoryInterface;

class FindUserByTelegramIdQueryHandler
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    public function __invoke(FindUserByTelegramIdQuery $query): UserDTO
    {
        $user = $this->userRepository->findByTelegramId($query->telegram_id);

        if (!$user) {
            throw new \Exception('User not found');
        }

        return UserDTO::fromEntity($user);
    }

}