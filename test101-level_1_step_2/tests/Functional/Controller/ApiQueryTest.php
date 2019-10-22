<?php

declare(strict_types=1);

namespace Meero\Tests\Functional;

use Meero\Model\Area;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ApiQueryTest extends WebTestCase
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

    public function testInvokeControllerWithGetMethod(): void
    {
        // insert tests data into the database
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

        // search intervention area by uuid
        $client->request('GET', '/api/area', [
            'uuid' => '62b75357-ddde-458d-9f1c-a01867cd8dad',
        ], [], []);

        // the response should to have a status code equals to 200
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // the response content shoold to be a json and result shoold to be equals to this one
        $json = '[{"uuid":"62b75357-ddde-458d-9f1c-a01867cd8dad","polygon":[{"lat":12,"lng":14},{"lat":12,"lng":14},{"lat":12,"lng":14},{"lat":12,"lng":14}],"created_at":"2019-10-11 22:04:25+00:00","updated_at":"2019-10-11 22:04:25+00:00"}]';

        $this->assertEquals($json, $client->getResponse()->getContent());
    }
}
