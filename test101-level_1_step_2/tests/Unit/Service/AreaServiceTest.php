<?php

namespace Meero\Tests\Unit\Service;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Meero\Entity\Area;
use Meero\Service\AreaService;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

class AreaServiceTest extends TestCase
{
    public function testQuery()
    {
        $repository = $this->createMock(ObjectRepository::class);
        $repository->expects($this->once())
            ->method('findBy')
            ->with(['id' => '1234567890'])
            ->willReturn([]);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->any())
           ->method('getRepository')
            ->willReturn($repository);

        $serializer = $this->createMock(SerializerInterface::class);
        $serializer->expects($this->any())
            ->method('serialize')
            ->willReturn('[{}]');

        $areaService = new AreaService($entityManager, $serializer);

        $criteria = [
            'uuid' => '1234567890',
        ];

        $result = $areaService->query($criteria, AreaService::FORMAT_OBJECT);
        $this->assertIsArray($result);
    }

    public function testRemove()
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $serializer = $this->createMock(SerializerInterface::class);

        $areaService = new AreaService($entityManager, $serializer);

        $entity = new Area();
        $result = $areaService->remove($entity);

        $this->assertTrue($result);
    }

    public function testRemoveException()
    {
        $exception = $this->createMock(\Exception::class);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->method('flush')
            ->willThrowException($exception);

        $serializer = $this->createMock(SerializerInterface::class);
        $areaService = new AreaService($entityManager, $serializer);

        $entity = new Area();
        $result = $areaService->remove($entity);
        $this->assertFalse($result);
    }

    public function testSave()
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $serializer = $this->createMock(SerializerInterface::class);

        $areaService = new AreaService($entityManager, $serializer);

        $entity = new Area();
        $result = $areaService->save($entity);

        $this->assertInstanceOf(Area::class, $result);
    }

    public function testSaveException()
    {
        $exception = $this->createMock(\Exception::class);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->method('flush')
            ->willThrowException($exception);

        $serializer = $this->createMock(SerializerInterface::class);
        $areaService = new AreaService($entityManager, $serializer);

        $entity = new Area();
        $result = $areaService->save($entity);
        $this->assertNull($result);
    }
}
