<?php

namespace App\Tests\Functional\Tokens\Domain\Service;

use App\Tests\Tools\FakerTools;
use App\Tokens\Domain\Service\JwtTokenCreateService;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class JwtTokenCreateTest extends WebTestCase
{
    use FakerTools;

    private JwtTokenCreateService $jwtService;

    public function setUp(): void
    {
        parent::setUp();

        $this->jwtService = $this::getContainer()->get(JwtTokenCreateService::class);
    }

    public function testCreate()
    {
        $user_id = $this->getFaker()->numberBetween();
        $jwt = $this->jwtService->create($user_id);

        list($headersB64, $payloadB64, $sig) = explode('.', $jwt);

        $decoded = json_decode(base64_decode($headersB64), true);
        self::assertArrayHasKey('typ', $decoded);
        self::assertArrayHasKey('alg', $decoded);

        $decoded = json_decode(base64_decode($payloadB64), true);
        self::assertArrayHasKey('iat', $decoded);
        self::assertArrayHasKey('nbf', $decoded);
        self::assertArrayHasKey('exp', $decoded);
        self::assertArrayHasKey('sub', $decoded);
        self::assertArrayHasKey('iss', $decoded);
        self::assertArrayHasKey('aud', $decoded);

        $publicKeyFile = __DIR__.'/../../../../../config/jwt/public.rem';

        // Create a private key of type "resource"
        $publicKey = file_get_contents($publicKeyFile);
        $decoded2 = JWT::decode($jwt, new Key($publicKey, 'RS256'));
        $decoded2 = (array) $decoded2;
        self::assertArrayHasKey('iat', $decoded2);
        self::assertArrayHasKey('nbf', $decoded2);
        self::assertArrayHasKey('exp', $decoded2);
        self::assertArrayHasKey('sub', $decoded2);
        self::assertArrayHasKey('iss', $decoded2);
        self::assertArrayHasKey('aud', $decoded2);
    }
}
