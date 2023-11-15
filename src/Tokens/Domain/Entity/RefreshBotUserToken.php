<?php

namespace App\Tokens\Domain\Entity;

use App\Shared\Domain\Service\UlidService;

class RefreshBotUserToken
{
    private string $id;
    /**
     * Время создания токена.
     */
    private int $created_at;
    /**
     * Время когда был перевыпущен токен
     * Если null, то токен уже перевыпущен и новый нельзя создать.
     */
    private ?int $refresh_at = null;
    /**
     * Значение токена.
     */
    private string $token;
    /**
     * Что за пользователь из бд тг.
     */
    private int $user_id;

    /**
     * Что за бот
     */
    private int $bot_id;

    /**
     * Юзерагент пользователя.
     */
    private string $user_agent;

    /**
     * ip пользователя.
     */
    private string $ip;

    public function __construct(string $token, int $user_id, string $ip, int $bot_id, string $user_agent, ?int $created_at)
    {
        $this->id = UlidService::generate();
        $this->token = $token;
        $this->user_id = $user_id;
        $this->ip = $ip;
        $this->bot_id = $bot_id;
        $this->user_agent = $user_agent;
        if (is_null($created_at)) {
            $this->created_at = time();
        } else {
            $this->created_at = $created_at;
        }
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

    public function getRefreshAt(): ?int
    {
        return $this->refresh_at;
    }

    public function getCreatedAt(): int
    {
        return $this->created_at;
    }

    public function setRefreshAt(int $refresh_at): void
    {
        $this->refresh_at = $refresh_at;
    }

    public function getBotId(): int
    {
        return $this->bot_id;
    }

    public function getUserAgent(): string
    {
        return $this->user_agent;
    }
}
