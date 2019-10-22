<?php

namespace Meero\Tests\Unit\Controller;

use Meero\Controller\SaveAreaController;
use Meero\Service\AreaService;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class SaveAreaControllerTest extends TestCase
{
    public function testInvoke()
    {
        // mock serializer
        $serializer = $this->createMock(SerializerInterface::class);

        // mock area service
        $serviceArea = $this->createMock(AreaService::class);

        $invokable = new SaveAreaController($serviceArea, $serializer);

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
