<?php

namespace App\Controller;

use App\Repository\VisitorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class VisitorController
 * @package App\Controller
 */
class VisitorController extends AbstractController
{
    /**
     * @Route("/visitors", name="visitors")
     */
    public function index(VisitorRepository $repository)
    {
        return $this->render('visitor/index.html.twig', [
            'controller_name' => 'VisitorController',
        ]);
    }
    /**
     * @Route("/visitors/{id}", name="visitor")
     */
    public function visitor($id, VisitorRepository $repository)
    {
        return $this->render('visitor/one.html.twig', [
            'controller_name' => 'VisitorController',
            'visitor' => $repository->find($id)
        ]);
    }
}
