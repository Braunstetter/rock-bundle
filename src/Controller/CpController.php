<?php


namespace Rock\Controller;


use Braunstetter\PluginBundle\Services\Plugins;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CpController extends AbstractController
{
    public function index(Plugins $plugins): Response
    {
        dump($plugins->findAll());
        return $this->render('@Rock/cp/dashboard.html.twig');
    }
}