<?php

namespace Meero\Tests\Unit\Controller;

use Meero\Controller\QueryAreaController;
use Meero\Service\AreaService;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class QueryAreaControllerTest extends TestCase
{
    public function testInvoke()
    {
        // mock service area
        $serviceArea = $this->createMock(AreaService::class);
        $serviceArea->expects($this->any())
            ->method('query')
            ->willReturn('[]');

        $invokable = new QueryAreaController($serviceArea);

        // controller should to be invokable
        $this->assertIsCallable($invokable);

        // mock Request
        $request = $this->createMock(Request::class);

        // invoke controller
        $response = $invokable($request);

        // response should to be a Response
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertEquals('[]', $response->getContent());
    }
}
