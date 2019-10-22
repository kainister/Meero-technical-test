<?php

declare(strict_types=1);

namespace Meero\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ApiSaveTest extends WebTestCase
{
    /** @var \Doctrine\DBAL\Connection */
    private $connection;

    protected function setUp(): void
    {
        self::$kernel = static::createKernel();
        self::$kernel->boot();
        $this->connection = self::$kernel->getContainer()->get('doctrine.dbal.default_connection');
    }

    protected function tearDown(): void
    {
        self::$kernel->shutdown();
    }

    public function testApiSimpleSaveRequest(): void
    {
        // init http client
        $client = static::createClient();

        // define the json payload
        $json = '{"uuid":"62b75357-ddde-458d-9f1c-a01867cd8dad","polygon":[[48.846658,2.3808096000000205],[48.84967,2.380809799999952],[48.848389947986746,2.3852728958007674]],"created_at":"2019-10-15 18:40:18+00:00","updated_at":"2019-10-15 18:40:18+00:00"}';

        // search intervention area by uuid
        $client->request('POST', '/api/area', [], [], [], $json);

        // the response should to have a status code equals to 200
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // the response content shoold to be a json and result shoold to be equals to this one
        $this->assertContains('uuid', $client->getResponse()->getContent());
        $this->assertContains('polygon', $client->getResponse()->getContent());
        $this->assertContains('created_at', $client->getResponse()->getContent());
        $this->assertContains('updated_at', $client->getResponse()->getContent());
    }

    public function testApiSimpleUpdateRequest(): void
    {
        $this->connection->insert('area', [
                'id' => '62b75357-ddde-458d-9f1c-a01867cd8dad',
                'created_at' => '2019-10-11 22:04:25.184982',
                'updated_at' => '2019-10-11 22:04:25.184982',
                'polygon' => serialize([
                    ['lat' => 12, 'lng' => 14],
                    ['lat' => 12, 'lng' => 14],
                    ['lat' => 12, 'lng' => 14],
                    ['lat' => 12, 'lng' => 14],
                ]),
            ]
        );
        // init http client
        $client = static::createClient();

        // define the json payload
        $json = '{"uuid":"62b75357-ddde-458d-9f1c-a01867cd8dad","polygon":[[48.846658,2.3808096000000205],[48.84967,2.380809799999952],[48.848389947986746,2.3852728958007674]],"created_at":"2019-10-15 18:40:18+00:00","updated_at":"2019-10-15 18:40:18+00:00"}';

        // search intervention area by uuid
        $client->request('POST', '/api/area/62b75357-ddde-458d-9f1c-a01867cd8dad', [], [], [], $json);

        // the response should to have a status code equals to 200
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        // the response content shoold to be a json and result shoold to be equals to this one
        $this->assertContains('uuid', $client->getResponse()->getContent());
        $this->assertContains('62b75357-ddde-458d-9f1c-a01867cd8dad', $client->getResponse()->getContent());
        $this->assertContains('polygon', $client->getResponse()->getContent());
        $this->assertContains('created_at', $client->getResponse()->getContent());
        $this->assertContains('updated_at', $client->getResponse()->getContent());
    }
}
