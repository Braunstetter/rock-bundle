<?php


namespace Rock\Test\app\src\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TemplateHookTestController extends AbstractController
{
    #[Route('/template-hook-test', name: 'template_hook_test')]
    public function index(): Response
    {
        return $this->render('template_hook/template_hook_test.html.twig');
    }
}