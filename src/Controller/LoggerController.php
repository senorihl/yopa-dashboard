<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LoggerController extends AbstractController
{
    /**
     * @Route("/logs", name="logger")
     */
    public function index()
    {
        return $this->render('logger/index.html.twig', [
            'controller_name' => 'LoggerController',
        ]);
    }
}
