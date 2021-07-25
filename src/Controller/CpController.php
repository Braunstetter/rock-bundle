<?php


namespace Rock\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CpController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('@Rock/cp/dashboard.html.twig');
    }
}