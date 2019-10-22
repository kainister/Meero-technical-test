<?php

namespace Meero\Tests\Functional\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class CmdQueryTest extends KernelTestCase
{
    /** @var \Doctrine\DBAL\Connection|object|null */
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

    public function testExecute()
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

        $kernel = static::createKernel();
        $application = new Application($kernel);
        static::bootKernel();

        $command = $application->find('meero:area:query');

        $commandTester = new CommandTester($command);

        $commandTester->execute([
            'command' => $command->getName(),
        ]);

        $output = $commandTester->getDisplay();

        $this->assertEquals(0, $commandTester->getStatusCode());
        $this->assertContains('"uuid":"62b75357-ddde-458d-9f1c-a01867cd8dad"', $output);
    }

    public function testExecuteByUuid()
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
        $this->connection->insert('area', [
                'id' => '62b75357-ddde-458d-9f1c-a01867cd8000',
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

        $kernel = static::createKernel();
        $application = new Application($kernel);
        static::bootKernel();

        $command = $application->find('meero:area:query');

        $commandTester = new CommandTester($command);

        $commandTester->execute([
            'command' => $command->getName(),
            '--uuid' => '62b75357-ddde-458d-9f1c-a01867cd8dad',
        ]);

        $output = $commandTester->getDisplay();

        $this->assertEquals(0, $commandTester->getStatusCode());
        $this->assertNotContains('"uuid":"62b75357-ddde-458d-9f1c-a01867cd8000"', $output);
    }
}
