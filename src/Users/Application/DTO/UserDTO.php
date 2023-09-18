<?php

namespace App\Users\Application\DTO;

use App\Users\Domain\Entity\User;

class UserDTO
{
    public int $id;
    public int $telegram_id;
    public string $username;
    public string $first_name;
    public string $last_name;
    public string $link;
    public string $type;

    public function getArray(): array
    {
        return [
            'id' => $this->id,
            'telegram_id' => $this->telegram_id,
            'username' => $this->username,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'link' => $this->link,
            'type' => $this->type
        ];
    }

    public static function fromEntity(?User $user)
    {
        if(is_null($user))
            return null;
        $dto = new UserDto();
        $dto->id = $user->getId();
        $dto->telegram_id = $user->getTelegramId();
        $dto->username = $user->getUsername();
        $dto->first_name = $user->getFirstName();
        $dto->last_name = $user->getLastName();
        $dto->link = 'link';
        $dto->type = 'private';
        return $dto;
    }
}