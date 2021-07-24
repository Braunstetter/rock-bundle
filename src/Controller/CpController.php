<?php


namespace Rock\Controller;


use Rock\Services\Menu;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CpController extends AbstractController
{
    public function index(Menu $menu): Response
    {
        return $this->render('@Rock/cp/dashboard.html.twig');
    }
}