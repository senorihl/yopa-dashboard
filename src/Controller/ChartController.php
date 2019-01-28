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
            $simple[$visitsCount['device']] = $visitsCount['count'];
        }

        return new JsonResponse($simple);
    }

    /**
     * @Route("/language-repartition.json", name="language-repartition")
     * @param VisitRepository $repository
     * @return JsonResponse
     */
    public function languageRepartition(VisitRepository $repository)
    {
        $simple = [];
        $repartition = $repository->findLanguageRepartition();
        foreach ($repartition as $visitsCount) {
            $simple[$visitsCount['language']] = $visitsCount['count'];
        }

        return new JsonResponse($simple);
    }

    /**
     * @Route("/top-url.json", name="top-url")
     * @param VisitRepository $repository
     * @return JsonResponse
     */
    public function topUrl(VisitRepository $repository)
    {
        $simple = [];
        $repartition = $repository->findTopUrl();

        foreach ($repartition as $visitsCount) {
            if (!isset($simple[$visitsCount['hour']])) {
                $simple[$visitsCount['hour']] = [];
            }
            if (!isset($simple[$visitsCount['hour']][$visitsCount['url']])) {
                $simple[$visitsCount['hour']][$visitsCount['url']] = [];
            }

            $simple[$visitsCount['hour']][$visitsCount['url']] = $visitsCount['count'];
        }

        return new JsonResponse($simple);
    }
}
