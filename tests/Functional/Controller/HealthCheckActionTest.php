<?php

namespace App\Tests\Functional\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class HealthCheckActionTest extends WebTestCase
{
    public function testPing(): void
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, '/ping');

        $this->assertResponseIsSuccessful();
        $jsonResult = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($jsonResult['status'], 'ok');
    }

    public function testError(): void
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, '/not-found');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
}
