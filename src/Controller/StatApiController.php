<?php

namespace App\Controller;

use App\Repository\RemboursementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatApiController extends AbstractController
{
    



    #[Route('/stath/stath', name: 'app_statique')]
    public function displayDonStats(RemboursementRepository $donRepository): Response
    {
        $stats = $donRepository->countdarrive();

        return $this->render('Stat/stat.html.twig', [
            'stats' => $stats,
        ]);
    }
}