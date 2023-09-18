<?php

namespace App\Users\Domain\Repository;

use App\Users\Domain\Entity\User;

interface UserRepositoryInterface
{
    /**
     * Создает пользователя
     *
     * @param User $user
     * @return void
     */
    public function add(User $user): void;

    /**
     * Find user by telegram id
     * @param int $id
     * @return User|null
     */
    public function findByTelegramId(int $id): ?User;

    /**
     * Find user by id
     * @param int $id
     * @return User|null
     */
    public function findById(int $id): ?User;
}