<?php

namespace App\Controller;

use App\Repository\VoyageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatController extends AbstractController
{
    



    #[Route('/stat/stat', name: 'statiqueA')]
    public function displayDonStats(VoyageRepository $donRepository): Response
    {
        $stats = $donRepository->countdarrive();

        return $this->render('Stat/index.html.twig', [
            'stats' => $stats,
        ]);
    }
}