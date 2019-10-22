<?php

namespace Meero\Command;

use Meero\Service\AreaService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportAreaCommand extends Command
{
    protected static $defaultName = 'meero:area:import';

    /** @var AreaService */
    private $areaService;

    public function __construct(AreaService $areaService, string $name = null)
    {
        $this->areaService = $areaService;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->addArgument('file', InputArgument::REQUIRED, 'the csv file to import');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $polygon = $input->getArgument('file');

        return 255;
    }
}
