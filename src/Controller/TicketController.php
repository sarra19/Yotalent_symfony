<?php

namespace App\Controller;

use App\Entity\Ticket;

use App\Entity\Evenement;
use App\Form\TicketType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FormType;

use App\Repository\TicketRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

#[Route('/ticket')]
class TicketController extends AbstractController
{
    #[Route('/', name: 'app_ticket_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $tickets = $entityManager
            ->getRepository(Ticket::class)
            ->findAll();

        return $this->render('ticket/index.html.twig', [
            'tickets' => $tickets,
        ]);
    }
    #[Route('/front', name: 'front', methods: ['GET','POST'])]
    public function front(Request $request,EntityManagerInterface $entityManager): Response
    {
        

        $result = null;

        if ($request->isMethod('POST')) {
            $selectedNumber = $request->request->get('number');
            if ($selectedNumber !== null && $selectedNumber >= 1 && $selectedNumber <= 5) {
                $result = $selectedNumber * 20;
            }
        }
        

        return $this->render('ticket/indexfrontT.html.twig', [
            'result' => $result,
        ]);
        
         
            return $this->render('ticket/indexfrontT.html.twig');
        }
    
      

            
       
    


    #[Route('/new', name: 'app_ticket_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event=$entityManager
            ->getRepository(Evenement::class)
            ->find($ticket->getIdev());
            $ticket->setNomev($event->getNomev());
            $entityManager->persist($ticket);
            $entityManager->flush();

            return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ticket/new.html.twig', [
            'ticket' => $ticket,
            'form' => $form,
        ]);
    }

    #[Route('/{idt}', name: 'app_ticket_show', methods: ['GET'])]
    public function show(Ticket $ticket): Response
    {
        return $this->render('ticket/show.html.twig', [
            'ticket' => $ticket,
        ]);
    }


    #[Route( name: 'app_front', methods: ['GET'])]
    public function show1(Ticket $ticket): Response
    {
        return $this->render('ticket/front.html.twig', [
            
        ]);
    }




    #[Route('/{idt}/edit', name: 'app_ticket_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ticket/edit.html.twig', [
            'ticket' => $ticket,
            'form' => $form,
        ]);
    }

    #[Route('/{idt}', name: 'app_ticket_delete', methods: ['POST'])]
    public function delete(Request $request, Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ticket->getIdt(), $request->request->get('_token'))) {
            $entityManager->remove($ticket);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
    }


    // #[Route('/{idt}',name: 'app_payer', methods: ['GET', 'POST'])]
    // public function accepter(Request $request,  Ticket $ticket, EntityManagerInterface $entityManager): Response
    // {
    
    //     $ticket->setEtat('yes') ; // Set dc property to true
       
      
    //         $entityManager->flush();
            
            
    //         return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
              
            
    
       
    // }


    // /**
    //  * @Route( name="ticket_update_etat")
    //  */
    // public function updateEtat(Ticket $ticket, EntityManagerInterface $entityManager): Response
    // {
    //     if ($ticket->getIdev()->getId() == 99) {
    //         $ticket->setEtat(true);
    //         $entityManager->persist($ticket);
    //         $entityManager->flush();

         

    //     return $this->render('front', [
    //         'tickets' => $tickets,


    //     ]);
    // }  
    
    

    #[Route('/{idt}/payer',name: 'payer', methods: ['GET', 'POST'])]
    public function payer(Request $request, Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
    



        
        $ticket->setEtat('1') ; // Set etat property to yes
       
      
            $entityManager->flush();
            return $this->redirectToRoute('front', [
                
                
                'ticket' => $ticket,


            ], Response::HTTP_SEE_OTHER);
            
        
    
       
    }





    
 } 






    
    



       
   


   

 



      

  


    

