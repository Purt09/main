<?php

namespace App\Users\Domain\Entity;

class User
{
    private int $id;
    private ?string $username;
    private ?string $auth_key;
    private ?string $last_name;
    private ?string $first_name;

    private int $status = 1;

    private int $created_at = 1;

    private int $updated_at = 1;

    private string $verification_token;

    private int $money = 0;

    private ?int $ref_id = null;

    private int $code = 1111;

    private bool $two_auth = true;

    private int $identity;

    private int $type;

    private bool $is_password = false;

    private int $money_ref = 0;

    public function __construct(
        int     $tg_id,
        ?string $first_name,
        ?string $last_name,
        ?string $username,
        int     $type,
    )
    {
        $this->identity = $tg_id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->username = $username;
        $this->type = $type;
    }

    public function setVerificationToken(string $verification_token): void
    {
        $this->verification_token = $verification_token;
    }

    public function setAuthKey(?string $auth_key): void
    {
        $this->auth_key = $auth_key;
    }

    public function getId():int
    {
        return $this->id;
    }

    public function getTelegramId():int
    {
        return $this->identity;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }
}