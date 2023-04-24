<?php

namespace App\Controller;

use App\Repository\EspaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatController extends AbstractController
{
    /**
     * @Route("/stttat", name="app_starrt_index")
     */
    public function index(EspaceRepository $repository): Response
    {
        $counts = $repository->countByVoteIntervals([0, 10, 20, 50]);
        $total = array_sum($counts);
        $percentages = [];
        foreach ($counts as $count) {
            $percentages[] = round($count / $total * 100, 2);
        }
        return $this->render('Stat/Stat.html.twig', [
            'counts' => $counts,
            'percentages' => $percentages,
            'total' => $total,
        ]);
    }
}
