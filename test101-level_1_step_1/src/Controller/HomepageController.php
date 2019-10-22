<?php

namespace Meero\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HomepageController
{
    /** @var Environment */
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/")
     */
    public function __invoke(Request $request): Response
    {
        return new Response($this->twig->render('homepage.html.twig'));
    }
}
