<?php

namespace App\Controller;
use Knp\Bundle\SnappyBundle\KnpSnappyBundle;

use App\Entity\Ticket;
use App\Entity\Planning;

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
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use App\Repository\TicketRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Snappy\Pdf;








#[Route('/ticket')]
class TicketController extends AbstractController
{
   /**
     * @Route("/", name="app_ticket_index", methods={"GET"})
     */
    public function index(Request $request, EntityManagerInterface $entityManager, PaginatorInterface $paginator): Response
    {
        $queryBuilder = $entityManager->createQueryBuilder()
        ->select('e')
        ->from(Ticket::class, 'e');

    // Recherche basique par prixt, nomev, etat, ou idt
    $searchQuery = $request->query->get('search');
    if ($searchQuery) {
        $queryBuilder->andWhere($queryBuilder->expr()->orX(
            $queryBuilder->expr()->like('e.prixt', ':searchQuery'),
            $queryBuilder->expr()->eq('e.nomev', ':searchQuery'),
            $queryBuilder->expr()->eq('e.etat', ':searchQuery'),
            $queryBuilder->expr()->eq('e.idt', ':searchQuery'),
        ))
        ->setParameter('searchQuery', $searchQuery);
    }

    // Tri
    $sort = $request->query->get('sort');
    if ($sort) {
        $queryBuilder->orderBy('e.' . $sort, 'ASC');
    }

    // Pagination
    $page = $request->query->getInt('page', 1); // numéro de la page en cours, 1 par défaut
    $itemsPerPage = 5; // nombre d'éléments par page

    $pagination = $paginator->paginate(
        $queryBuilder->getQuery(), // passez la requête au paginateur
        $page,
        $itemsPerPage,
        [
            'template' => 'pagination/pagination_custom.twig', // chemin vers votre fichier Twig personnalisé
            'distance' => 3
        ]
  
    );
 

    return $this->render('ticket/index.html.twig', [
        'items' => $pagination->getItems(),
        'currentPage' => $pagination->getCurrentPageNumber(),
        'totalPages' => $pagination->getPageCount(),
        'pagination' => $pagination,
    ]);

  
    
        
        
    }


    

        #[Route('/front/{idev}', name: 'app_ticket_frontev', methods: ['GET'], requirements: ['idev' => '\d+'])]
    public function frontu(Request $request, EntityManagerInterface $entityManager, $idev): Response
    {
        $evenements = $evenements
            ->getRepository(Ticket::class)
            ->findBy(['idev' => $idev]);
    
    
            return $this->render('ticket/indexfrontT.html.twig', [
                'evenements' => $evenements,
                'idev' => $idev,
            ]);
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

    #[Route( name: 'about', methods: ['GET'])]
    public function cette(Ticket $ticket): Response
    {
        return $this->render('ticket/about.html.twig', [
            
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
    
    
    
 

    
    #[Route('/{idt}/payer', name: 'payer', methods: ['GET', 'POST'])]
    public function payer(Request $request, MailerInterface $mailer, Ticket $ticket, EntityManagerInterface $entityManager, Pdf $snappy): Response
    {
        $ticket->setEtat('1'); // Set etat property to yes
    
        // Générer le contenu HTML de la facture en utilisant le template Twig
        $html = $this->renderView('invoices/ticket_invoice.html.twig', [
            'ticket' => $ticket,
        ]);
    
        // Générer le PDF et enregistrer le fichier dans un dossier temporaire
        $pdfFilePath = tempnam(sys_get_temp_dir(), 'facture_') . '.pdf';
        $snappy->generateFromHtml($html, $pdfFilePath);
    
        // Créer l'e-mail et joindre la facture PDF en pièce jointe
        $email = (new Email())
            ->from('hadir.elayeb@esprit.tn')
            ->to('hadir.elayeb@esprit.tn')
            ->subject('YOTALENT')
            ->html('<p>Here is the ticket for your Event  (Reférance Ticket: '.($ticket->getIdt()).'):</p>')
            ->attachFromPath($pdfFilePath, 'ticket.pdf', 'application/pdf');
    
        // Envoyer l'e-mail
        try {
            $mailer->send($email);
            $this->addFlash('message', 'E-mail de paiement envoyé !');
        } catch (TransportExceptionInterface $e) {
            // Gérer les erreurs d'envoi de courriel
            $this->addFlash('error', 'Une erreur s\'est produite lors de l\'envoi de l\'e-mail : ' . $e->getMessage());
        }
    
        // Enregistrer l'état du ticket dans la base de données et rediriger vers la page d'accueil
        $entityManager->flush();
        return $this->render('ticket/about.html.twig');

    }








    
 } 






    
    



       
   


   

 



      

  


    

