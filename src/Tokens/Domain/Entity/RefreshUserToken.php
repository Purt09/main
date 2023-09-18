<?php

namespace App\Tokens\Domain\Entity;

use App\Shared\Domain\Service\UlidService;

class RefreshUserToken
{
    const STATUS_NOT_ACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;
    private string $id;
    private int $created_at;
    private int $refresh_at;
    private string $token;
    private int $user_id;
    private string $ip;
    private string $user_agent;
    private int $status;
    public function __construct(int $refresh_at, string $token, int $user_id, string $ip, string $user_agent, int $status)
    {
        $this->id = UlidService::generate();
        $this->created_at = time();
        $this->refresh_at = $refresh_at;
        $this->token = $token;
        $this->user_id = $user_id;
        $this->ip = $ip;
        $this->user_agent = $user_agent;
        $this->status = $status;
    }

    public function getId(): string
    {
        return $this->id;
    }
}