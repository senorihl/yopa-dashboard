<?php

namespace App\Controller;

use App\Repository\VisitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ChartController
 * @package App\Controller
 *
 * @Route("/chart", name="chart_")
 */
class ChartController extends AbstractController
{
    /**
     * @Route("/device-repartition.json", name="device-repartition")
     * @param VisitRepository $repository
     * @return JsonResponse
     */
    public function deviceRepartition(VisitRepository $repository)
    {
        $simple = [];
        $repartition = $repository->findDeviceRepartition();
        foreach ($repartition as $visitsCount) {
            $simple[$visitsCount['device']] = $visitsCount[1];
        }

        return new JsonResponse($simple);
    }
}
