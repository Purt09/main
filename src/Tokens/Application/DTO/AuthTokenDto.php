<?php

namespace App\Tokens\Application\DTO;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotBlank;

class AuthTokenDto
{
    #[ORM\Column(type: 'string')]
    #[NotBlank]
    public string $jwt;
    #[NotBlank]
    #[ORM\Column(type: 'string', length: 64)]
    public string $token;
}
