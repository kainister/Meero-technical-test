<?php

namespace Meero\Controller;

use Meero\Service\AreaService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QueryAreaController
{
    /** @var AreaService */
    private $areaService;

    public function __construct(AreaService $areaService)
    {
        $this->areaService = $areaService;
    }

    /**
     * @Route("/api/area", methods={"GET"}, name="api_area_query")
     */
    public function __invoke(Request $request): Response
    {
        $criteria = [];

        if (null !== $uuid = $request->get('uuid', null)) {
            $criteria['id'] = $uuid;
        }

        $result = $this->areaService->query($criteria, AreaService::FORMAT_JSON);

        return new Response($result, Response::HTTP_OK, [
            'Content-Type' => 'application/json',
        ]);
    }
}
