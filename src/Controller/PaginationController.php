<?php

namespace App\Controller;

use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class PaginationController extends AbstractController
{
    /**
     * @Route("/tickets", name="tickets")
     */
    public function tickets(Request $request, PaginatorInterface $paginator, TicketRepository $ticketRepository)
    {
        // Récupération de la page actuelle et de la limite
        $page = (int) $request->query->get('page', 1);
        $limit = (int) $request->query->get('limit', 5);

        // Création de la pagination
        $pagination = $paginator->paginate(
            $ticketRepository->createQueryBuilder('t'), // Utilisez le QueryBuilder pour récupérer les tickets
            $page,
            $limit
        );

        // Renvoie la vue avec la pagination
        return $this->render('ticket/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}
