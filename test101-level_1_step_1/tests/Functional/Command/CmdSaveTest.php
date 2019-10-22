<?php

namespace Meero\Tests\Functional\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class CmdSaveTest extends KernelTestCase
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
        $kernel = static::createKernel();
        $application = new Application($kernel);
        static::bootKernel();

        $command = $application->find('meero:area:save');

        $commandTester = new CommandTester($command);

        $commandTester->execute([
            'command' => $command->getName(),
            ],
        );

        $output = $commandTester->getDisplay();

        $this->assertEquals(0, $commandTester->getStatusCode());
        $this->assertContains('saved', $output);
    }

    public function testExecuteWithUuid()
    {
        // insert tests data into the database
        $this->connection->insert('area', [
                'id' => '62b75357-ddde-458d-9f1c-a01867cd8dad',
                'created_at' => '2019-10-11 22:04:25.184982',
                'updated_at' => '2019-10-11 22:04:25.184982',
                'polygon' => serialize([
                    [48.846658, 2.3808096000000205],
                    [48.84967, 2.380809799999952],
                    [48.848389947986746, 2.3852728958007674],
                ]),
            ]
        );

        $kernel = static::createKernel();
        $application = new Application($kernel);
        static::bootKernel();

        $command = $application->find('meero:area:save');

        $commandTester = new CommandTester($command);

        $commandTester->execute([
            'command' => $command->getName(),
            '--uuid' => '62b75357-ddde-458d-9f1c-a01867cd8dad',
            '10 10 10 10 10 10',
        ]);

        $output = $commandTester->getDisplay();

        $this->assertEquals(0, $commandTester->getStatusCode());
        $this->assertContains('entity "62b75357-ddde-458d-9f1c-a01867cd8dad" found', $output);
    }
}
