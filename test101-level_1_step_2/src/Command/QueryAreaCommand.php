<?php

namespace Meero\Command;

use Meero\Service\AreaService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class QueryAreaCommand extends Command
{
    protected static $defaultName = 'meero:area:query';

    /** @var AreaService */
    private $areaService;

    public function __construct(AreaService $areaService, string $name = null)
    {
        $this->areaService = $areaService;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->addOption('uuid', 'u', InputOption::VALUE_OPTIONAL, 'the area uuid', null);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $criteria = [];

        // get uuid from optional arguments
        if (null !== $uuid = $input->getOption('uuid')) {
            $criteria['uuid'] = $uuid;
        }

        $result = $this->areaService->query($criteria, AreaService::FORMAT_JSON);

        $output->writeln($result);
    }
}
