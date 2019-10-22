<?php

namespace Meero\Tests\Unit\Doctrine\ORM\Id;

use Doctrine\ORM\EntityManager;
use Meero\Doctrine\ORM\Id\GuidGenerator;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class GuidGeneratorTest extends TestCase
{
    public function testGenerate()
    {
        // mock entity manager
        $em = $this->createMock(EntityManager::class);
        // mock entity
        $entity = $this->createMock(\stdClass::class);

        $generator = new GuidGenerator();
        $result = $generator->generate($em, $entity);

        // the uuid must be uuid4 format
        $this->assertRegExp('/\w{8}-\w{4}-\w{4}-\w{4}-\w{12}/', $result->toString());
    }
}
