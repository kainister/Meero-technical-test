<?php

namespace Meero\Controller;

use Meero\Entity\Area;
use Meero\Service\AreaService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class SaveAreaController
{
    /** @var AreaService */
    private $areaService;

    /** @var SerializerInterface */
    private $serializer;

    public function __construct(AreaService $areaService, SerializerInterface $serializer)
    {
        $this->areaService = $areaService;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/api/area", methods={"POST", "PUT"}, name="api_area_save")
     * @Route("/api/area/{uuid}", methods={"POST", "PUT"}, name="api_area_update")
     */
    public function __invoke(Request $request): Response
    {
        $entity = $this->serializer->deserialize($request->getContent(), Area::class, AreaService::FORMAT_JSON);

        if (null !== $uuid = $request->get('uuid', null)) {
            $criteria = [];
            $criteria['id'] = $uuid;
            $entities = $this->areaService->query($criteria);
            if (true === isset($entities[0])) {
                $entity = $entities[0];
            }
        }

        $result = $this->areaService->save($entity, AreaService::FORMAT_JSON);
        $result = ['result' => $result];

        return new Response($this->serializer->serialize($result, AreaService::FORMAT_JSON), Response::HTTP_OK, [
            'Content-Type' => 'application/json',
        ]);
    }
}
