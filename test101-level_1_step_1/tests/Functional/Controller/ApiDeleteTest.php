<?php

declare(strict_types=1);

namespace Meero\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ApiDeleteTest extends WebTestCase
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

    public function testApiSimpleDeleteRequest(): void
    {
        // insert tests data into the database
        $this->connection->insert('area', [
                'id' => '62b75357-ddde-458d-9f1c-a01867cd8dad',
                'created_at' => '2019-10-11 22:04:25.184982',
                'updated_at' => '2019-10-11 22:04:25.184982',
                'polygon' => serialize([
                    ['lat' => 48.846658, 'lng' => 2.3808096000000205],
                    ['lat' => 48.84967, 'lng' => 2.380809799999952],
                    ['lat' => 48.848389947986746, 'lng' => 2.3852728958007674],
                ]),
            ]
        );

        // init http client
        $client = static::createClient();

        // search intervention area by uuid
        $client->request('DELETE', '/api/area', [
            'uuid' => '62b75357-ddde-458d-9f1c-a01867cd8dad',
        ], [], []);

        // the response should to have a status code equals to 200
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // the response content shoold to be a json and result shoold to be equals to this one
        $this->assertEquals('{"result":true}', $client->getResponse()->getContent());
    }

    public function testApiSimpleDeleteRequestEnityNotFound(): void
    {
        // insert tests data into the database
        $this->connection->insert('area', [
            'id' => '62b75357-ddde-458d-9f1c-a01867cd8dad',
            'created_at' => '2019-10-11 22:04:25.184982',
            'updated_at' => '2019-10-11 22:04:25.184982',
            'polygon' => serialize([
                ['lat' => 48.846658, 'lng' => 2.3808096000000205],
                ['lat' => 48.84967, 'lng' => 2.380809799999952],
                ['lat' => 48.848389947986746, 'lng' => 2.3852728958007674],
            ]),
        ]
    );

        // init http client
        $client = static::createClient();

        // search intervention area by uuid
        $client->request('DELETE', '/api/area', [
        'uuid' => '62b75357-ddde-458d-9f1c-a01867cd8000',
            ], [], []);

        // the response should to have a status code equals to 200
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // the response content shoold to be a json and result shoold to be equals to this one
        $this->assertContains('entity not found', $client->getResponse()->getContent());
    }
}
