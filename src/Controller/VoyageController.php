<?php

namespace App\Controller;

use App\Entity\Voyage;
use App\Form\VoyageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/voyage')]
class VoyageController extends AbstractController
{
    #[Route('/show_in_map/{idvoy}', name: 'app_voy_map', methods: ['GET'])]
    public function Map( Voyage $idvoy,EntityManagerInterface $entityManager ): Response
    {
    
        $idvoy = $entityManager
            ->getRepository(Voyage::class)->findBy( 
                ['idvoy'=>$idvoy ]
            );
        return $this->render('Voyage/api_arcgis.html.twig', [
            'Voyage' => $idvoy,
        ]);
    }
    
    



    #[Route('/', name: 'app_voyage_index', methods: ['GET'])]
public function index(Request $request, EntityManagerInterface $entityManager): Response
{
    $queryBuilder = $entityManager->createQueryBuilder()
        ->select('e')
        ->from(Voyage::class, 'e');

    // Advanced search
    $searchQuery = $request->query->get('searchQuery');
    if ($searchQuery) {
        $queryBuilder->andWhere(
            $queryBuilder->expr()->orX(
                $queryBuilder->expr()->like('e.idvoy', ':searchQuery'),
                $queryBuilder->expr()->like('e.datedvoy', ':searchQuery'),
                $queryBuilder->expr()->like('e.datervoy', ':searchQuery')
            )
        )->setParameter('searchQuery', '%'.$searchQuery.'%');
    }









    // Sorting
    $sort = $request->query->get('sort');
    if ($sort) {
        $queryBuilder->orderBy('e.' . $sort, 'ASC');
    }

    $voyages = $queryBuilder->getQuery()->getResult();
// Filtrer les voyages par destination
$tunis_voyages = array_filter($voyages, function($voyage) {
    return $voyage->getDestination() === 'Tunis';
});
$bizerte_voyages = array_filter($voyages, function($voyage) {
    return $voyage->getDestination() === 'Bizerte';
});
$sousse_voyages = array_filter($voyages, function($voyage) {
    return $voyage->getDestination() === 'Sousse';
});
    return $this->render('voyage/index.html.twig', [
        'voyages' => $voyages,
        'tunis_voyages' => $tunis_voyages,
        'bizerte_voyages' => $bizerte_voyages,
        'sousse_voyages' => $sousse_voyages,
    ]);
}

    #[Route('/new', name: 'app_voyage_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $voyage = new Voyage();
        $form = $this->createForm(VoyageType::class, $voyage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($voyage);
            $entityManager->flush();

            return $this->redirectToRoute('app_voyage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('voyage/new.html.twig', [
            'voyage' => $voyage,
            'form' => $form,
        ]);
    }

    #[Route('/{idvoy}', name: 'app_voyage_show', methods: ['GET'])]
    public function show(Voyage $voyage): Response
    {
        return $this->render('voyage/show.html.twig', [
            'voyage' => $voyage,
        ]);
    }

    #[Route('/{idvoy}/edit', name: 'app_voyage_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Voyage $voyage, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VoyageType::class, $voyage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_voyage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('voyage/edit.html.twig', [
            'voyage' => $voyage,
            'form' => $form,
        ]);
    }

    #[Route('/{idvoy}', name: 'app_voyage_delete', methods: ['POST'])]
    public function delete(Request $request, Voyage $voyage, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$voyage->getIdvoy(), $request->request->get('_token'))) {
            $entityManager->remove($voyage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_voyage_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/voyage/front', name: 'app_voyage_front', methods: ['GET'])]
    public function front(EntityManagerInterface $entityManager): Response
    {
        $voyages = $entityManager
            ->getRepository(Voyage::class)
            ->findAll();

        return $this->render('voyage/indexFront.html.twig', [
            'voyages' => $voyages,
        ]);
    }
    #[Route('/voyage/front/{idc}', name: 'app_voyage_frontc', methods: ['GET'], requirements: ['idc' => '\d+'])]
public function frontc(EntityManagerInterface $entityManager, $idc = null): Response
{
    $voyages = $entityManager
        ->getRepository(Voyage::class)
        ->findBy(['idc' => $idc]);

    return $this->render('voyage/indexFront.html.twig', [
        'voyages' => $voyages,
    ]);
    
}

/**
 * @Route("/voyage/statistiques", name="app_voyage_stats")
 */
public function stats(): Response
{
    // Récupérer tous les voyages depuis la base de données
    $voyages = $this->getDoctrine()->getRepository(Voyage::class)->findAll();

    // Filtrer les voyages par destination
    $tunis_voyages = array_filter($voyages, function($voyage) {
        return $voyage->getDestination() === 'Tunis';
    });
    $bizerte_voyages = array_filter($voyages, function($voyage) {
        return $voyage->getDestination() === 'Bizerte';
    });
    $sousse_voyages = array_filter($voyages, function($voyage) {
        return $voyage->getDestination() === 'Sousse';
    });

    // Rendre la vue contenant les statistiques
    return $this->render('voyage/index.html.twig', [
        'tunis_voyages' => $tunis_voyages,
        'bizerte_voyages' => $bizerte_voyages,
        'sousse_voyages' => $sousse_voyages,
    ]);




}
}