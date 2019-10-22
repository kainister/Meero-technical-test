<?php

namespace Meero\Tests\Unit\Controller;

use Meero\Controller\QueryAreaController;
use Meero\Service\AreaService;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RemoveAreaControllerTest extends TestCase
{
    public function testInvoke()
    {
        // mock area service
        $serviceArea = $this->createMock(AreaService::class);

        $invokable = new QueryAreaController($serviceArea);

        // controller should to be invokable
        $this->assertIsCallable($invokable);

        // mock Request
        $request = $this->createMock(Request::class);

        // invoke controller
        $response = $invokable($request);

        // response should to be a Response
        $this->assertInstanceOf(Response::class, $response);
    }
}
