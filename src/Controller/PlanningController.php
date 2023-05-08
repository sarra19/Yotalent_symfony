<?php

namespace App\Controller;

use App\Entity\Planning;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;


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
use App\Entity\PdfGeneratorService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
#[Route('/planning')]
class PlanningController extends AbstractController
{
    
    #[Route("/AllPlannings", name: "lists")]
    public function getStudents(PlanningRepository $repo, SerializerInterface $serializer, LoggerInterface $logger)
    {
       
        $planning = $repo->findAll();
        //* Nous utilisons la fonction normalize qui transforme le tableau d'objets 
        //* students en  tableau associatif simple.
        // $studentsNormalises = $normalizer->normalize($students, 'json', ['groups' => "students"]);

        // //* Nous utilisons la fonction json_encode pour transformer un tableau associatif en format JSON
        // $json = json_encode($studentsNormalises);

        $json = $serializer->serialize($planning, 'json', ['groups' => "Planning"]);

        //* Nous renvoyons une réponse Http qui prend en paramètre un tableau en format JSON
        return new Response($json);
      
    


        
    }



   








    #[Route("/Plannings/{idp}", name: "planning")]
    public function StudentId($idp, NormalizerInterface $normalizer, PlanningRepository $repo)
    {
        $planning = $repo->find($idp);
        $studentNormalises = $normalizer->normalize($planning, 'json', ['groups' => "Planning"]);
        return new Response(json_encode($studentNormalises));
    }
    
    #[Route("/addPlanningJSONs", name: "addPlanningJSON")]
    public function addPlanningJSON(Request $req,NormalizerInterface $Normalizer,EntityManagerInterface $EM)
    {

        $planning = new Planning();
        $event=$EM
        ->getRepository(Evenement::class)
        ->find($req->get('idev'));
        $planning->setIdev($event);
        //$ticket->setNomev($event->getNomev());
        $planning->setHour($req->get('hour'));
        $planning->setNomactivite($req->get('nomactivite'));
        //$ticket->setEtat($req->get('etat'));
        $EM->persist($planning);
        $EM->flush();
        

        $jsonContent = $Normalizer->normalize($planning, 'json', ['groups' => 'Planning']);
        return new Response(json_encode($jsonContent));
    }

    #[Route("/updatePlanningtJSONs/{idp}", name: "updatePlanningtJSON")]
    public function updatePlanningtJSON(Request $req, $idp, NormalizerInterface $Normalizer,EntityManagerInterface $EM)
    {

         $planning = new Planning();
        $event=$EM
        ->getRepository(Evenement::class)
        ->find($req->get('idev'));
       $planning->setIdev($event);
       $planning = $EM->getRepository(Planning::class)->find($req->get('idp'));
       $planning->setHour($req->get('hour'));
       $planning->setNomactivite($req->get('nomactivite'));
       //$ticket->setEtat($req->get('etat'));
    
       $EM->flush();

       $jsonContent = $Normalizer->normalize($planning, 'json', ['groups' => 'Planning']);
       return new Response("StudenTicket updated successfully " . json_encode($jsonContent));
    }

    #[Route("/deletePlanningJSONs/{idp}", name: "deletePlanningJSON")]
    public function deleteTicketJSON(Request $req, $idp, NormalizerInterface $Normalizer,EntityManagerInterface $EM)
    {

        $planning = new Planning();
      
        $planning = $EM->getRepository(Planning::class)->find($idp);
        $EM->remove($planning);
        $EM->flush();
        $jsonContent = $Normalizer->normalize($planning, 'json', ['groups' => 'Planning']);
        return new Response("Ticket deleted successfully " . json_encode($jsonContent));
    }



   
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
public function frontP(Request $request,EntityManagerInterface $entityManager, $idev = null,PaginatorInterface $paginator): Response
{
    $plannings = $entityManager
        ->getRepository(Planning::class)
        ->findBy(['idev' => $idev]);
        
        $plannings = $paginator->paginate(
            $plannings, /* query NOT result */
            $request->query->getInt('page', 1),
            3
        );


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
    #[Route('/pdf/planning', name: 'generator_services')]
    public function pdfPlanning(): Response
    { 
        $planning= $this->getDoctrine()
        ->getRepository(Planning::class)
        ->findAll();

   

        $html =$this->renderView('pdf/indexP.html.twig', ['planning' => $planning]);
        $pdfGeneratorService=new PdfGeneratorService();
        $pdf = $pdfGeneratorService->generatePdf($html);

        return new Response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="document.pdf"',
        ]);
}
}
