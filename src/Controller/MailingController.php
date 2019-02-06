<?php

namespace App\Controller;

use App\Repository\VisitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MailingController extends AbstractController
{
    /**
     * @Route("/mailings", name="mailings")
     */
    public function index(VisitRepository $repository)
    {
        return $this->render('mailing/index.html.twig', [
            'visits' => $repository->findBy(['type' => 'mailing'], ['occurredAt' => 'DESC'], 20, 0),
            'pixel' => ['action' => 'Mailings', 'breadcrumb' => ['Home']],
            'controller_name' => 'MailingController',
        ]);
    }
}
