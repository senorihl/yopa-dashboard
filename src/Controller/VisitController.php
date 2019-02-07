<?php

namespace App\Controller;

use App\Repository\VisitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class VisitController
 * @package App\Controller
 */
class VisitController extends AbstractController
{
    /**
     * @Route("/visits", name="visits")
     */
    public function index(VisitRepository $repository)
    {
        return $this->render('visit/index.html.twig', [
            'controller_name' => 'VisitController',
            'visits' => $repository->findBy(['type' => 'page'], ['occurredAt' => 'DESC'], 20, 0),
            'pixel' => ['action' => 'Visits', 'breadcrumb' => ['Home'], 'silent' => true]
        ]);
    }
    /**
     * @Route("/visits/{id}", name="visit")
     */
    public function one($id, VisitRepository $repository)
    {
        return $this->render('visit/one.html.twig', [
            'visit' => $repository->find($id),
            'pixel' => ['breadcrumb' => ['Home', 'Visits'], 'action' => 'Single', 'silent' => true]
        ]);
    }
}
