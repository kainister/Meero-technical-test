<?php

namespace Meero\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Meero\Entity\Area;

class AreaFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; ++$i) {
            $area = new Area();
            $area->setPolygon([
                ['lat' => 12, 'lng' => 14],
                ['lat' => 12, 'lng' => 14],
                ['lat' => 12, 'lng' => 14],
                ['lat' => 12, 'lng' => 14],
            ]);
            $manager->persist($area);
            $manager->flush();
        }
    }
}
