<?php

namespace Meero\Tests\Unit\Controller;

use Meero\Controller\HomepageController;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class HomepageControllerTest extends TestCase
{
    public function testInvoke()
    {
        // mock twig environment
        $environement = $this->createMock(Environment::class);

        $invokable = new HomepageController($environement);

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
