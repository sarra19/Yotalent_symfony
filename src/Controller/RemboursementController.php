<?php

namespace App\Controller;

use App\Entity\Remboursement;
use App\Form\RemboursementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/remboursement')]
class RemboursementController extends AbstractController
{
    #[Route('/', name: 'app_remboursement_index', methods: ['GET'])]
    public function index(Request $request, EntityManagerInterface $entityManager,PaginatorInterface $paginator): Response
    {
        $queryBuilder = $entityManager->createQueryBuilder()
        ->select('e')
        ->from(Remboursement::class, 'e');

    // Basic search by username or nbvotes
    $searchQuery = $request->query->get('search');
    if ($searchQuery) {
        $queryBuilder->andWhere($queryBuilder->expr()->orX(
            $queryBuilder->expr()->like('e.dc', ':searchQuery'),
            $queryBuilder->expr()->eq('e.idu', ':searchQuery'),
            $queryBuilder->expr()->eq('e.idt', ':searchQuery'),
            $queryBuilder->expr()->eq('e.idrem', ':searchQuery'),
            
        ))
        ->setParameter('searchQuery', $searchQuery);
    }

    // Sorting
    $sort = $request->query->get('sort');
    if ($sort) {
        $queryBuilder->orderBy('e.' . $sort, 'ASC');
    }

    $remboursements = $queryBuilder->getQuery()->getResult();
    //pagination
    $pagination = $paginator->paginate(
        $remboursements,
        $request->query->getInt('page', 1), 4
    );

        return $this->render('remboursement/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/new', name: 'app_remboursement_new', methods: ['GET', 'POST'])]
    public function new(Request $request,MailerInterface $mailer, EntityManagerInterface $entityManager): Response
    {
        $remboursement = new Remboursement();
        $form = $this->createForm(RemboursementType::class, $remboursement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($remboursement);
            $entityManager->flush();

            $email = (new Email())
            ->from('hadir.elayeb@esprit.tn')
            ->To('hadir.elayeb@esprit.tn')
            ->subject('Rembourssement ticket')
                    ->text("your refund is sent with success");
            // ->text('<p> Bonjour</p> unde demande de réinitialisation de mot de passe a été effectuée. Veuillez cliquer sur le lien suivant :".$url,
            // "text/html');
            try {
             $mailer->send($email);
             $this->addFlash('message','E-mail  de rembourssement envoyé :');
         } catch (TransportExceptionInterface $e) {
             // Gérer les erreurs d'envoi de courriel
         }
         $this->addFlash('success', 'refund is add');

            return $this->redirectToRoute('app_remboursement_new', [], Response::HTTP_SEE_OTHER);
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
    public function delete(Request $request,MailerInterface $mailer, Remboursement $remboursement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$remboursement->getIdrem(), $request->request->get('_token'))) {
            $entityManager->remove($remboursement);


            $email = (new Email())
            ->from('hadir.elayeb@esprit.tn')
            ->To('hadir.elayeb@esprit.tn')
            ->subject('Rembourssement ticket')
                    ->text("your refund is refused");
            // ->text('<p> Bonjour</p> unde demande de réinitialisation de mot de passe a été effectuée. Veuillez cliquer sur le lien suivant :".$url,
            // "text/html');
            try {
             $mailer->send($email);
             $this->addFlash('message','E-mail  de rembourssement envoyé :');
         } catch (TransportExceptionInterface $e) {
             // Gérer les erreurs d'envoi de courriel
         }



            $entityManager->flush();
        }


        return $this->redirectToRoute('app_remboursement_index', [], Response::HTTP_SEE_OTHER);
    }


   #[Route('/{idrem}/accepter',name: 'app_remboursement_accepter', methods: ['GET', 'POST'])]
   public function accepter(Request $request,MailerInterface $mailer, Remboursement $remboursement, EntityManagerInterface $entityManager): Response
   {
   
       $remboursement->setDc('true') ; // Set dc property to true
       $email = (new Email())
       ->from('hadir.elayeb@esprit.tn')
       ->To('hadir.elayeb@esprit.tn')
       ->subject('Rembourssement ticket')
               ->text("your refund is accepted");
       // ->text('<p> Bonjour</p> unde demande de réinitialisation de mot de passe a été effectuée. Veuillez cliquer sur le lien suivant :".$url,
       // "text/html');
       try {
        $mailer->send($email);
        $this->addFlash('message','E-mail  de rembourssement envoyé :');
    } catch (TransportExceptionInterface $e) {
        // Gérer les erreurs d'envoi de courriel
    }
     
           $entityManager->flush();
           return $this->redirectToRoute('app_remboursement_index', [], Response::HTTP_SEE_OTHER);
           
       
   
      
   }


   









}