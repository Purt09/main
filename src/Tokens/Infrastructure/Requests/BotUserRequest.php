<?php

namespace App\Tokens\Infrastructure\Requests;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class BotUserRequest
{
    #[NotBlank]
    #[Positive]
    public int $bot_id;

    #[NotBlank]
    #[Length(min: 8)]
    public string $data;
}
