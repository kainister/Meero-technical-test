<?php

namespace Meero\Service;

use Doctrine\ORM\EntityManagerInterface;
use Meero\Entity\Area;
use Symfony\Component\Serializer\SerializerInterface;

final class AreaService
{
    const FORMAT_JSON = 'json';
    const FORMAT_OBJECT = 'object';

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var SerializerInterface */
    private $serializer;

    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer
    ) {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    /**
     * @return object[]
     */
    public function query($criteria, string $format = AreaService::FORMAT_OBJECT)
    {
        if (isset($criteria['uuid'])) {
            $criteria['id'] = $criteria['uuid'];
            unset($criteria['uuid']);
        }

        $repository = $this->entityManager->getRepository(Area::class);

        $entities = $repository->findBy($criteria);

        if (AreaService::FORMAT_JSON === $format) {
            return $this->serializer->serialize($entities, $format);
        }

        return $entities;
    }

    public function remove($entity)
    {
        try {
            $this->entityManager->remove($entity);
            $this->entityManager->flush();
        } catch (\Exception $exception) {
            return false;
        }

        return true;
    }

    public function save($entity)
    {
        try {
            $this->entityManager->persist($entity);
            $this->entityManager->flush();
        } catch (\Exception $exception) {
            return null;
        }

        return $entity;
    }
}
