<?php

namespace Meero\Command;

use Meero\Service\AreaService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RemoveAreaCommand extends Command
{
    protected static $defaultName = 'meero:area:remove';

    /** @var AreaService */
    private $areaService;

    public function __construct(AreaService $areaService, string $name = null)
    {
        $this->areaService = $areaService;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->addArgument('uuid', InputArgument::REQUIRED, 'the area uuid');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $uuid = $input->getArgument('uuid');

        $entities = $this->areaService->query(['uuid' => $uuid]);

        if (false === isset($entities[0])) {
            $output->writeln(sprintf('entity "%s" not found', $uuid));

            return 255;
        }

        $output->writeln(sprintf('entity "%s" found', $uuid));

        $this->areaService->remove($entities[0]);

        $output->writeln(sprintf('entity "%s" removed ', $uuid));

        return 0;
    }
}
