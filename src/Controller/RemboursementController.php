<?php

namespace App\Controller;

use App\Entity\Remboursement;
use App\Form\RemboursementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/remboursement')]
class RemboursementController extends AbstractController
{
    #[Route('/', name: 'app_remboursement_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $remboursements = $entityManager
            ->getRepository(Remboursement::class)
            ->findAll();

        return $this->render('remboursement/index.html.twig', [
            'remboursements' => $remboursements,
        ]);
    }

    #[Route('/new', name: 'app_remboursement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $remboursement = new Remboursement();
        $form = $this->createForm(RemboursementType::class, $remboursement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($remboursement);
            $entityManager->flush();

            return $this->redirectToRoute('app_remboursement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('remboursement/new.html.twig', [
            'remboursement' => $remboursement,
            'form' => $form,
        ]);
    }

    #[Route('/{idrem}', name: 'app_remboursement_show', methods: ['GET'])]
    public function show(Remboursement $remboursement): Response
    {
        return $this->render('remboursement/show.html.twig', [
            'remboursement' => $remboursement,
        ]);
    }

    #[Route('/{idrem}/edit', name: 'app_remboursement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Remboursement $remboursement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RemboursementType::class, $remboursement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_remboursement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('remboursement/edit.html.twig', [
            'remboursement' => $remboursement,
            'form' => $form,
        ]);
    }

    #[Route('/{idrem}', name: 'app_remboursement_delete', methods: ['POST'])]
    public function delete(Request $request, Remboursement $remboursement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$remboursement->getIdrem(), $request->request->get('_token'))) {
            $entityManager->remove($remboursement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_remboursement_index', [], Response::HTTP_SEE_OTHER);
    }


   #[Route('/{idrem}/accepter',name: 'app_remboursement_accepter', methods: ['GET', 'POST'])]
   public function accepter(Request $request, Remboursement $remboursement, EntityManagerInterface $entityManager): Response
   {
   
       $remboursement->setDc('true') ; // Set dc property to true
      
     
     
          
          
           $entityManager->flush();
           return $this->redirectToRoute('app_remboursement_index', [], Response::HTTP_SEE_OTHER);
       
   
      
   }









}
