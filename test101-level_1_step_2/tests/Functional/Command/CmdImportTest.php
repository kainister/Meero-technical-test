<?php

namespace Meero\Tests\Functional\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class CmdImportTest extends KernelTestCase
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

        $command = $application->find('meero:area:import');

        $commandTester = new CommandTester($command);

        $commandTester->execute([
                'command' => $command->getName(),
                'file' => 'data/interventions_area.csv',
            ]
        );

        // get console output
        $output = $commandTester->getDisplay();

        // check console status code
        $this->assertEquals(0, $commandTester->getStatusCode());

        // check if data was saved into the database
        $data = $this->connection->executeQuery('select * from area')->fetchAll();
        $this->assertNotFalse($data);

        $this->assertContains('70e66a09-263a-4eaa-a0d7-38fb943c6a11', $data);
        $this->assertContains('70e66a09-263a-4eaa-a0d7-38fb943c6a10', $data);
        $this->assertContains('70e66a09-263a-4eaa-a0d7-38fb943c6a12', $data);
    }
}
