<?php

namespace App\Tokens\Domain\Entity;

use App\Shared\Domain\Service\UlidService;

class RefreshBotUserToken
{
    private string $id;
    private int $created_at;
    private int $refresh_at;
    private string $token;
    private int $user_id;
    private string $ip;
    public function __construct(int $refresh_at, string $token, int $user_id, string $ip)
    {
        $this->id = UlidService::generate();
        $this->created_at = time();
        $this->refresh_at = $refresh_at;
        $this->token = $token;
        $this->user_id = $user_id;
        $this->ip = $ip;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function getRefreshAt(): int
    {
        return $this->refresh_at;
    }

    public function getCreatedAt(): int
    {
        return $this->created_at;
    }
}