<?php

namespace Meero\Controller;

use Meero\Service\AreaService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class RemoveAreaController
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
     * @Route("/api/area", methods={"DELETE"}, name="api_area_remove")
     */
    public function __invoke(Request $request): Response
    {
        $criteria = [];

        if (null !== $uuid = $request->get('uuid', null)) {
            $criteria['id'] = $uuid;
        }

        $entities = $this->areaService->query($criteria);

        if (0 >= count($entities)) {
            $result = ['error' => 'entity not found'];

            return new Response($this->serializer->serialize($result, AreaService::FORMAT_JSON), Response::HTTP_OK, [
                'Content-Type' => 'application/json',
            ]);
        }

        $result = ['result' => $this->areaService->remove($entities[0])];

        return new Response($this->serializer->serialize($result, AreaService::FORMAT_JSON), Response::HTTP_OK, [
            'Content-Type' => 'application/json',
        ]);
    }
}
