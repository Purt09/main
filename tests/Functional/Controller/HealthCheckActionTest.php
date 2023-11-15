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
        $this->assertEquals($jsonResult['ok'], true);
        $this->assertEquals($jsonResult['status'], 200);
        $this->assertEquals($jsonResult['result'], 'ok');
    }

    public function testError(): void
    {
        $client = static::createClient();

        $client->request(Request::METHOD_GET, '/not-found1');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    public function testNotFound(): void
    {
        $client = static::createClient();

        $client->request(Request::METHOD_GET, '/not-found');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('not found', json_decode($client->getResponse()->getContent(), true)['title']);
    }

    public function testNotAllowed(): void
    {
        $client = static::createClient();

        $client->request(Request::METHOD_GET, '/not-allowed');

        $jsonResult = $client->getResponse()->getContent();
        $this->assertEquals(405, $client->getResponse()->getStatusCode());
    }

    public function testAuth(): void
    {
        $client = static::createClient();

        $client->request(Request::METHOD_GET, '/not-auth');

        $jsonResult = $client->getResponse()->getContent();
        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }

    public function testAccess(): void
    {
        $client = static::createClient();

        $client->request(Request::METHOD_GET, '/not-access');

        $jsonResult = $client->getResponse()->getContent();
        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }

    public function testNotParams(): void
    {
        $client = static::createClient();

        $client->request(Request::METHOD_GET, '/not-params');

        $jsonResult = $client->getResponse()->getContent();
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }
}
