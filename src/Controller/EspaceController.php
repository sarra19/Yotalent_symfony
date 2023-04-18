<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Espacetalent;
use App\Entity\User;

use App\Form\EspacetalentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;


#[Route('/espace')]
class EspaceController extends AbstractController
{
  
   
    #[Route('/', name: 'app_espace_index', methods: ['GET'])]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $queryBuilder = $entityManager->createQueryBuilder()
            ->select('e')
            ->from(Espacetalent::class, 'e');

        // Basic search by username or nbvotes
        $searchQuery = $request->query->get('search');
        if ($searchQuery) {
            $queryBuilder->andWhere($queryBuilder->expr()->orX(
                $queryBuilder->expr()->like('e.username', ':searchQuery'),
                $queryBuilder->expr()->eq('e.nbvotes', ':searchQuery'),
                $queryBuilder->expr()->eq('e.idest', ':searchQuery'),

            ))
            ->setParameter('searchQuery', $searchQuery);
        }

        // Sorting
        $sort = $request->query->get('sort');
        if ($sort) {
            $queryBuilder->orderBy('e.' . $sort, 'ASC');
        }

        $espacetalents = $queryBuilder->getQuery()->getResult();

        return $this->render('espace/index.html.twig', [
            'espacetalents' => $espacetalents,
        ]);
    }

    
    
    #[Route('/app', name: 'app')]
    public function envoyerEmail(Request $request, MailerInterface $mailer)
    {
        if ($request->isMethod('POST')) {
            $expediteur = $request->request->get('expediteur');
            $destinataire = 'sarra.benhamida@esprit.tn';
            $sujet = $request->request->get('sujet');
            $message = $request->request->get('message');

            $email = (new Email())
                ->from($expediteur)
                ->to($destinataire)
                ->subject($sujet)
                ->text($message);

            $mailer->send($email);

            return new Response('E-mail envoyé !');
        }

        return $this->render('email/index.html.twig');
    }
  
 #[Route('/espace/front/{idcat}', name: 'app_espace_frontcat', methods: ['GET'], requirements: ['idcat' => '\d+'])]
public function frontcat(EntityManagerInterface $entityManager, $idcat = null): Response
{
    $espacetalents = $entityManager
        ->getRepository(Espacetalent::class)
        ->findBy(['idcat' => $idcat]);

    return $this->render('espace/index.FrontEE.html.twig', [
        'espacetalents' => $espacetalents,
    ]);
}

  /**
 * @Route("/api/generate-pdf", name="api_generate_pdf", methods={"GET"})
 */
public function generatePdf(EntityManagerInterface $entityManager): Response
{
    $espacetalents = $entityManager
    ->getRepository(Espacetalent::class)
    ->findAll();
    $options = new Options();
    $options->set('defaultFont', 'Arial');
    $dompdf = new Dompdf($options);

    $html = $this->renderView('pdf/pdf.html.twig', ['espacetalents' => $espacetalents]);


    $dompdf->loadHtml($html);
    $dompdf->render();

    $output = $dompdf->output();

    $response = new Response($output);
    $response->headers->set('Content-Type', 'application/pdf');
    $response->headers->set('Content-Disposition', 'attachment; filename="pdf.pdf"');

    return $response;
}

 

    
    
    #[Route('/frontE', name: 'app_espace_front', methods: ['GET'])]
    public function front(EntityManagerInterface $entityManager): Response
    {
        $espacetalents = $entityManager
            ->getRepository(Espacetalent::class)
            ->findAll();

        return $this->render('espace/index.FrontEE.html.twig', [
            'espacetalents' => $espacetalents,
        ]);
    }

  


    #[Route('/new', name: 'app_espace_new', methods: ['GET', 'POST'])]
    public function new(Request $request,MailerInterface $mailer, EntityManagerInterface $entityManager): Response
    {
        $espacetalent = new Espacetalent();
        $form = $this->createForm(EspacetalentType::class, $espacetalent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

           // Handle file upload
        $file = $form['image']->getData();
        if ($file) {
            $fileName = uniqid().'.'.$file->guessExtension();

            try {
                $file->move(
                    $this->getParameter('uploads'),
                    $fileName
                );
            } catch (FileException $e) {
                // handle exception if something happens during file upload
            }

            // Update entity with file name
            $espacetalent->setImage($fileName);

        }

      
     
            $entityManager->persist($espacetalent);
            $entityManager->flush();

            
            $email = (new Email())
            ->from('sarra.benhamida@esprit.tn')
            ->To('sarra.benhamida@esprit.tn')
            ->subject('nouveau ajout')
                    ->text("espace talent ajouté");
           
            try {
             $mailer->send($email);
             $this->addFlash('message','E-mail envoyé :');
         } catch (TransportExceptionInterface $e) {
             // Gérer les erreurs d'envoi de courriel
         }

         //   $notifier->send(new Notification('EspaceTalent  ajouter avec succées ', ['browser']));
            return $this->redirectToRoute('app_espace_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('espace/new.html.twig', [
            'espacetalent' => $espacetalent,
            'form' => $form,
        ]);
    }
      
      
 #[Route('/front/{idu}', name: 'app_espace_frontu', methods: ['GET'], requirements: ['idu' => '\d+'])]
 public function frontu(EntityManagerInterface $entityManager, $idu = null): Response
 {
     $espacetalents = $entityManager
         ->getRepository(Espacetalent::class)
         ->findBy(['idu' => $idu]);
 
     return $this->render('espace/index.FrontE.html.twig', [
         'espacetalents' => $espacetalents,
         'idu' => $idu,
 
     ]);
 }
 
 #[Route('/newE/{idu}', name: 'app_espace_newE', methods: ['GET', 'POST'], requirements: ['idu' => '\d+'])]
 public function newE(Request $request, EntityManagerInterface $entityManager, $idu): Response
{
    // Retrieve the User entity based on the given $idu
    $user = $entityManager->getRepository(User::class)->find($idu);
    
    if (!$user) {
        throw $this->createNotFoundException('User not found');
    }

    $espacetalent = new Espacetalent();
    $espacetalent->setIdu($user); // Set the user for the new Espacetalent entity

    $form = $this->createForm(EspacetalentType::class, $espacetalent);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Handle file upload...
        $file = $form['image']->getData();
        if ($file) {
            $fileName = uniqid().'.'.$file->guessExtension();

            try {
                $file->move(
                    $this->getParameter('uploads'),
                    $fileName
                );
            } catch (FileException $e) {
                // handle exception if something happens during file upload
            }

            // Update entity with file name
            $espacetalent->setImage($fileName);

        }

        $entityManager->persist($espacetalent);
        $entityManager->flush();

        return $this->redirectToRoute('app_espace_frontu', ['idu' => $idu], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('espace/newE.html.twig', [
        'espacetalent' => $espacetalent,
        'form' => $form,
    ]);
}
#[Route('/espace/{idest}', name: 'app_espace_deleteE', methods: ['POST'])]
public function deleteE(Request $request, Espacetalent $espacetalent, EntityManagerInterface $entityManager): Response
{
    // Make sure that the CSRF token is valid before deleting the entity
    if ($this->isCsrfTokenValid('delete'.$espacetalent->getIdest(), $request->request->get('_token'))) {
        // Remove the entity from the database
        $entityManager->remove($espacetalent);
        $entityManager->flush();
    }

    // Redirect to the user's Espacetalent index page after deleting the entity
    return $this->redirectToRoute('app_espace_frontu', ['idu' => $espacetalent->getIdu()->getId()], Response::HTTP_SEE_OTHER);
}


    #[Route('/{idest}', name: 'app_espace_show', methods: ['GET'])]
    public function show(Espacetalent $espacetalent): Response
    {
        return $this->render('espace/show.html.twig', [
            'espacetalent' => $espacetalent,
        ]);
    }

    
    #[Route('/{idest}/edit', name: 'app_espace_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Espacetalent $espacetalent, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EspacetalentType::class, $espacetalent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
              // Handle file upload
        $file = $form['image']->getData();
        if ($file) {
            $fileName = uniqid().'.'.$file->guessExtension();

            try {
                $file->move(
                    $this->getParameter('uploads'),
                    $fileName
                );
            } catch (FileException $e) {
                // handle exception if something happens during file upload
            }

            // Update entity with file name
            $espacetalent->setImage($fileName);

        }

            $entityManager->flush();

            return $this->redirectToRoute('app_espace_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('espace/edit.html.twig', [
            'espacetalent' => $espacetalent,
            'form' => $form,
        ]);
    }
    #[Route('/{idest}/editE', name: 'app_espace_editE', methods: ['GET', 'POST'])]
    public function editE(Request $request, Espacetalent $espacetalent, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EspacetalentType::class, $espacetalent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
              // Handle file upload
        $file = $form['image']->getData();
        if ($file) {
            $fileName = uniqid().'.'.$file->guessExtension();

            try {
                $file->move(
                    $this->getParameter('uploads'),
                    $fileName
                );
            } catch (FileException $e) {
                // handle exception if something happens during file upload
            }

            // Update entity with file name
            $espacetalent->setImage($fileName);

        }

            $entityManager->flush();

            return $this->redirectToRoute('app_espace_frontu', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('espace/editE.html.twig', [
            'espacetalent' => $espacetalent,
            'form' => $form,
        ]);
    }
    #[Route('/{idest}', name: 'app_espace_delete', methods: ['POST'])]
    public function delete(Request $request, Espacetalent $espacetalent, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$espacetalent->getIdest(), $request->request->get('_token'))) {
            $entityManager->remove($espacetalent);
            $entityManager->flush();
        }
    
        return $this->redirectToRoute('app_espace_index', [], Response::HTTP_SEE_OTHER);
    }
    
   
    
    
    
}
