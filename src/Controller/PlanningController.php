<?php

namespace App\Controller;

use App\Entity\Planning;
use App\Form\PlanningType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Evenement;
use App\Repository\PlanningRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
#[Route('/planning')]
class PlanningController extends AbstractController
{
   
    #[Route('/', name: 'app_planning_index', methods: ['GET'])]
    public function index(Request $request, EntityManagerInterface $entityManager ): Response
    {

        $queryBuilder = $entityManager->createQueryBuilder()
            ->select('e')
            ->from(Planning::class, 'e');

        // Basic search by username or nbvotes
        $searchQuery = $request->query->get('search');
        if ($searchQuery) {
            $queryBuilder->andWhere($queryBuilder->expr()->orX(
                $queryBuilder->expr()->like('e.hour', ':searchQuery'),
                $queryBuilder->expr()->eq('e.nomactivite', ':searchQuery'),
                $queryBuilder->expr()->eq('e.datepl', ':searchQuery'),
                $queryBuilder->expr()->eq('e.idp', ':searchQuery'),

            ))
            ->setParameter('searchQuery', $searchQuery);
        }

        // Sorting
        $sort = $request->query->get('sort');
        if ($sort) {
            $queryBuilder->orderBy('e.' . $sort, 'ASC');
        }

        $plannings = $queryBuilder->getQuery()->getResult();

        return $this->render('planning/index.html.twig', [
            'plannings' => $plannings,
        ]);
       
    }


    #[Route('/front', name: 'app_planning_front', methods: ['GET'])]
    public function front(EntityManagerInterface $entityManager): Response
    {
        $plannings = $entityManager
         ->getRepository(Planning::class)
            ->findAll();

        return $this->render('planning/indexFrontP.html.twig', [
            'plannings' => $plannings,
        ]);
    }
    #[Route('/planning/front/{idev}', name: 'app_planning_fronts', methods: ['GET'], requirements: ['idev' => '\d+'])]
public function frontP(EntityManagerInterface $entityManager, $idev = null): Response
{
    $plannings = $entityManager
        ->getRepository(Planning::class)
        ->findBy(['idev' => $idev]);

    return $this->render('planning/indexFrontP.html.twig', [
        'plannings' => $plannings,
    ]);
}

    #[Route('/new', name: 'app_planning_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,NotifierInterface $notifier): Response
    {

        $planning = new Planning();
        $form = $this->createForm(PlanningType::class, $planning);
     
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
           
            $event=$entityManager
            ->getRepository(Evenement::class)
            ->find($planning->getIdev());
            $entityManager->persist($planning);
            $nomactivite = $form->get('nomactivite')->getData();
            $plannings = $entityManager
            ->getRepository(Planning::class)
            ->findBy(['nomactivite'=>$nomactivite]);
            if (empty($plannings)) 
           {
            $entityManager->flush();
            $notifier->send(new Notification('Planning avec ajouter succées ', ['browser']));

            return $this->redirectToRoute('app_planning_index', [], Response::HTTP_SEE_OTHER);
        }
        else{
            $notifier->send(new Notification('Planning exist déja  ', ['browser']));
            return $this->redirectToRoute('app_planning_new', [], Response::HTTP_SEE_OTHER);

        }
    
            return $this->redirectToRoute('app_planning_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('planning/new.html.twig', [
            'planning' => $planning,
            'form' => $form,
        ]);
    }
 #[Route('/{idp}', name: 'app_planning_show', methods: ['GET'])]
   
    public function show( Planning $planning): Response
    {
       
        return $this->render('planning/show.html.twig', [
            'planning' => $planning,
        ]);
    }
   

    #[Route('/{idp}/edit', name: 'app_planning_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Planning $planning, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PlanningType::class, $planning);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_planning_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('planning/edit.html.twig', [
            'planning' => $planning,
            'form' => $form,
        ]);
    }

    #[Route('/{idp}', name: 'app_planning_delete', methods: ['POST'])]
    public function delete(Request $request, Planning $planning, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$planning->getIdp(), $request->request->get('_token'))) {
            $entityManager->remove($planning);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_planning_index', [], Response::HTTP_SEE_OTHER);
    }
}
