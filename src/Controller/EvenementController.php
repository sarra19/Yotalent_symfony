<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\Evenement1Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Planning;
use App\Repository\EvenementRepository;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/evenement')]
class EvenementController extends AbstractController
{
    #[Route('/', name: 'app_evenement_index', methods: ['GET','POST'])]
    public function index(ManagerRegistry $doctrine,Request $request,EvenementRepository $EvenementRepository ,EntityManagerInterface $entityManager ): Response
    {

        $evenements = $entityManager
            ->getRepository(Evenement::class)
            ->findAll();
        $back = null;
            
            if($request->isMethod("POST")){
                if ( $request->request->get('optionsRadios')){
                    $SortKey = $request->request->get('optionsRadios');
                    switch ($SortKey){
                        case 'nomev':
                            $evenements = $EvenementRepository->SortBynomev();
                            break;
    
                        case 'datedev':
                            $evenements = $EvenementRepository->SortBydatedev();
                            break;

                        case 'datefev':
                            $evenements = $EvenementRepository->SortBydatefev();
                            break;
                            case 'localisation':
                                $evenements = $EvenementRepository->SortBylocalisation();
                                break;
        
    
                    }
                }
                else
                {
                    $type = $request->request->get('optionsearch');//nekhdhou type mte3 recherche soit par titre wela par date wela par description
                    $value = $request->request->get('Search'); //nekhdhou lvaleur mte3 input (par ex ibtihel )
                    switch ($type){
                        case 'nomev':
                            $evenements = $EvenementRepository->findBynomev($value);
                            break;
    
                        case 'datedev':
                            $evenements = $EvenementRepository->findBydatedev($value);
                            break;
    
                        case 'datefev':
                            $evenements = $EvenementRepository->findBydatefev($value);
                            break;
    
                        case 'localisation':
                            $evenements = $EvenementRepository->findBylocalisation($value);
                            break;
    
    
                    }
                }

                if ( $evenements ){
                    $back = "success";
                }
                else{
                    $back = "failure";
                }
            }
        

           
            
        
        

        return $this->render('evenement/index.html.twig', [
            'evenements'=>$evenements,
            'back' => $back,
        ]);
       
    }

    #[Route('/front', name: 'app_evenement_indexfront', methods: ['GET'])]
    public function front(EntityManagerInterface $entityManager): Response
    {
        $evenements = $entityManager
        
            ->getRepository(Evenement::class)
            ->findAll();

        return $this->render('evenement/indexFront.html.twig', [
            'evenements' => $evenements,
        ]);
    }
   
   

    #[Route('/new', name: 'app_evenement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(Evenement1Type::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /////code image
            $file = $evenement->getImageev();
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('uploads'),$filename);
            $evenement->setImageev($filename);
            /////
            $entityManager->persist($evenement);
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{idev}', name: 'app_evenement_show', methods: ['GET'])]
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    #[Route('/{idev}/edit', name: 'app_evenement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Evenement1Type::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                        /////code image
                        $file = $evenement->getImageev();
                        $filename = md5(uniqid()).'.'.$file->guessExtension();
                        $file->move($this->getParameter('uploads'),$filename);
                        $evenement->setImageev($filename);
                        /////
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{idev}', name: 'app_evenement_delete', methods: ['POST'])]
    public function delete(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getIdev(), $request->request->get('_token'))) {
            $entityManager->remove($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
    }
}
