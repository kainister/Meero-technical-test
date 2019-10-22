<?php

namespace Meero\Command;

use Meero\Entity\Area;
use Meero\Service\AreaService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SaveAreaCommand extends Command
{
    protected static $defaultName = 'meero:area:save';

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
        $this->addArgument('polygon', InputArgument::IS_ARRAY, 'the area polygon');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entity = null;
        $uuid = $input->getOption('uuid');
        $polygon = $input->getArgument('polygon');

        if (null !== $uuid) {
            $criteria = [
                'uuid' => $input->getOption('uuid'),
            ];

            $entities = $this->areaService->query($criteria);

            if (true === isset($entities[0])) {
                $output->writeln(sprintf('entity "%s" found', $criteria['uuid']));
                $entity = $entities[0];
            }
        }

        $entity = null === $entity ? new Area() : $entity;

        if (null !== $uuid) {
            $entity->setId($uuid);
        }

        if (null !== $polygon) {
            $entity->setPolygon($polygon);
        }

        $result = $this->areaService->save($entity);

        $output->writeln(sprintf('entity "%s" saved ', $result->getId()));

        return 0;
    }
}
