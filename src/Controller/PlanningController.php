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
#[Route('/planning')]
class PlanningController extends AbstractController
{
   
    #[Route('/', name: 'app_planning_index', methods: ['GET','POST'])]
    public function index(ManagerRegistry $doctrine,Request $request,PlanningRepository $PlanningRepository ,EntityManagerInterface $entityManager ): Response
    {

        $plannings = $entityManager
            ->getRepository(Planning::class)
            ->findAll();
        $back = null;
            
            if($request->isMethod("POST")){
                if ( $request->request->get('optionsRadios')){
                    $SortKey = $request->request->get('optionsRadios');
                    switch ($SortKey){
                        case 'hour':
                            $plannings = $PlanningRepository->SortByhour();
                            break;
    
                        case 'nomactivite':
                            $plannings = $PlanningRepository->SortBynomactivite();
                            break;

                        case 'datepl':
                            $plannings = $PlanningRepository->SortBydatepl();
                            break;
                            
        
    
                    }
                }
                else
                {
                    $type = $request->request->get('optionsearch');//nekhdhou type mte3 recherche soit par titre wela par date wela par description
                    $value = $request->request->get('Search'); //nekhdhou lvaleur mte3 input (par ex ibtihel )
                    switch ($type){
                        case 'hour':
                            $plannings = $PlanningRepository->findByhour($value);
                            break;
    
                        case 'nomactivite':
                            $plannings = $PlanningRepository->findBynomactivite($value);
                            break;
    
                        case 'datepl':
                            $plannings = $PlanningRepository->findBydatepl($value);
                            break;
    
                        
    
    
                    }
                }

                if ( $plannings ){
                    $back = "success";
                }
                else{
                    $back = "failure";
                }
            }
        

           
            
        
        

        return $this->render('planning/index.html.twig', [
            'plannings'=>$plannings,
            'back' => $back,
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
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {

        $planning = new Planning();
        $form = $this->createForm(PlanningType::class, $planning);
     
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
           
            $event=$entityManager
            ->getRepository(Evenement::class)
            ->find($planning->getIdev());
            $entityManager->persist($planning);
            $entityManager->flush();

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
