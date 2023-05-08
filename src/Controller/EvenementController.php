<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\User;
use App\Form\Evenement1Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Planning;
use App\Repository\EvenementRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use App\Entity\PdfGeneratorService;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\MailerService; 
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Knp\Snappy\Pdf;
use App\Entity\Ticket;

use App\Form\TicketType;
use Psr\Log\LoggerInterface;

use Dompdf\Dompdf;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Mime\Address;
use App\Repository\TicketRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;





#[Route('/evenement')]
class EvenementController extends AbstractController
{
    #[Route("/polo", name: "polo")]
    public function getStudents(EvenementRepository $repo, SerializerInterface $serializer, LoggerInterface $logger)
    {
        $evenements = $repo->sortBynomev();
        
dump($evenements);
      
        $json = $serializer->serialize($evenements, 'json', ['groups' => "Evenement"]);

        //* Nous renvoyons une réponse Http qui prend en paramètre un tableau en format JSON
        return new Response($json);
    }
  

    

    
    
    #[Route("/addJSON", name: "addJSON")]
    public function addJSON(Request $req,   NormalizerInterface $Normalizer)
    {

        $em = $this->getDoctrine()->getManager();
        $evenement = new Evenement();
        $evenement->setNomev($req->get('nomev'));
       // $evenement->setDatedev($req->get('datedev'));
       // $evenement->setDatefev($req->get('datefev'));
        $evenement->setLocalisation($req->get('localisation'));
        $evenement->setImageev($req->get('imageev'));
        
        $em->persist($evenement);
        $em->flush();

        $jsonContent = $Normalizer->normalize($evenement, 'json', ['groups' => 'Evenement']);
        return new Response("Event ajouter successfully " .json_encode($jsonContent));
    }

    #[Route("/updateEventJSON/{idev}", name: "updateEventJSON")]
    public function updateEventJSON(Request $req, $idev, NormalizerInterface $Normalizer)
    {

        $em = $this->getDoctrine()->getManager();
        $evenement = $em->getRepository(Evenement::class)->find($idev);
        $evenement->setNomev($req->get('nomev'));
       // $evenement->setDatedev($req->get('datedev'));
       // $evenement->setDatefev($req->get('datefev'));
       $evenement->setLocalisation($req->get('localisation'));
       $evenement->setImageev($req->get('imageev'));
        

        $em->flush();

        $jsonContent = $Normalizer->normalize($evenement, 'json', ['groups' => 'Evenement']);
        return new Response("Event updated successfully " . json_encode($jsonContent));
    }
    #[Route("/deleteEventJSON/{idev}", name: "deleteEventJSON")]
    public function deleteEventJSON(Request $req, $idev, NormalizerInterface $Normalizer)
    {

        $em = $this->getDoctrine()->getManager();
        $evenement = $em->getRepository(Evenement::class)->find($idev);
        $em->remove($evenement);
        $em->flush();
        $jsonContent = $Normalizer->normalize($evenement, 'json', ['groups' => 'Evenement']);
        return new Response("Event deleted successfully " . json_encode($jsonContent));
    }
    
   
    #[Route("/Evenement/{idev}", name: "evenement")]
    public function EvenementId($idev, NormalizerInterface $normalizer, EvenementRepository $repo)
    {
        $evenement = $repo->find($idev);
        $evenementNormalises = $normalizer->normalize($evenement, 'json', ['groups' => "Evenement"]);
        return new Response(json_encode($evenementNormalises));
    }






    #[Route('/show_in_map/{idev}', name: 'app_evenement_map', methods: ['GET'])]
    public function Map( Evenement $idev, EntityManagerInterface $entityManager ): Response

    {

        $idev = $entityManager
            ->getRepository(Evenement::class)->findBy( 
                ['idev'=>$idev ]
            );
        return $this->render('evenement/api_arcgis.html.twig', [
            'evenements' => $idev,
        ]);
    }

    
    #[Route('/showmap/{idev}', name: 'app_evenement_mapf', methods: ['GET'])]
  public function Mapf( Evenement $idev, EntityManagerInterface $entityManager ): Response

    {
        

        $idev = $entityManager
            ->getRepository(Evenement::class)->findBy( 
                ['idev'=>$idev ]
            );
        return $this->render('evenement/map.html.twig', [
            'evenements' => $idev,
        ]);
    }

    #[Route('/', name: 'app_evenement_index', methods: ['GET'])]
    public function index(Request $request, EntityManagerInterface $entityManager ): Response
    {

        $queryBuilder = $entityManager->createQueryBuilder()
            ->select('e')
            ->from(Evenement::class, 'e');

        // Basic search by username or nbvotes
        $searchQuery = $request->query->get('search');
        if ($searchQuery) {
            $queryBuilder->andWhere($queryBuilder->expr()->orX(
                $queryBuilder->expr()->like('e.nomev', ':searchQuery'),
                $queryBuilder->expr()->eq('e.datedev', ':searchQuery'),
                $queryBuilder->expr()->eq('e.localisation', ':searchQuery'),
                $queryBuilder->expr()->eq('e.idev', ':searchQuery'),

            ))
            ->setParameter('searchQuery', $searchQuery);
        }

        // Sorting
        $sort = $request->query->get('sort');
        if ($sort) {
            $queryBuilder->orderBy('e.' . $sort, 'ASC');
        }

        $evenements = $queryBuilder->getQuery()->getResult();

        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenements,
        ]);
       
    }

    #[Route('/front', name: 'app_evenement_indexfront', methods: ['GET'])]
    public function front(Request $request,EntityManagerInterface $entityManager,PaginatorInterface $paginator): Response
    {
        $evenements = $entityManager
        
            ->getRepository(Evenement::class)
            ->findAll();

            $evenements = $paginator->paginate(
                $evenements, /* query NOT result */
                $request->query->getInt('page', 1),
                6
            );

        return $this->render('evenement/indexFront.html.twig', [
            'evenements' => $evenements,
        ]);
    }


/**
 * @Route("/front/{idev}", name="test", methods={"GET"})
 */
public function findby($idev, Request $request, EntityManagerInterface $entityManager): Response
{
    $evenement = $entityManager
        ->getRepository(Evenement::class)
        ->find($idev);
        

    return $this->render('evenement/test_hadir.html.twig', [
        'evenement' => $evenement,
    ]);
}



// #[Route('/front', name: 'front', methods: ['GET','POST'])]
// public function front2(Request $request,EntityManagerInterface $entityManager ): Response
// {
    

//     $result = null;

//     if ($request->isMethod('POST')) {
//         $selectedNumber = $request->request->get('number');
//         if ($selectedNumber !== null && $selectedNumber >= 1 && $selectedNumber <= 5) {
//             $result = $selectedNumber * 20;
            
//         }
    
//     }
    

//     return $this->render('evenement/test_hadir.html.twig', [
//         'result' => $result,
//     ]);
    

     
//         return $this->render('evenement/test_hadir.html.twig');
//     }

















    #[Route('/showmap/{idev}', name: 'app_evenement_mapf1', methods: ['GET'])]
    public function Mapf1( Evenement $idev,EntityManagerInterface $entityManager ): Response
    {

        $idev = $entityManager
            ->getRepository(Evenement::class)->findBy( 
                ['idev'=>$idev ]
            );
        return $this->render('evenement/test_hadir.html.twig', [
            'evenements' => $idev,
        ]);
    }


 












   
   
    #[Route('/new', name: 'app_evenement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, NotifierInterface $notifier,MailerService $mailer): Response
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
            $nomev = $form->get('nomev')->getData();
            $evenements = $entityManager
            ->getRepository(Evenement::class)
            ->findBy(['nomev'=>$nomev]);
            if (empty($evenements)) 
           {
            $entityManager->flush();
            $clients=$entityManager->getRepository(User::class)->findBy(['role'=>'participant']);
     foreach($clients as $client)
     {
        $to=$client->getEmail();
        $subject="Nouvel Evenement";
        $twig = $this->container->get('twig');
              $html=$twig->render('email/email.html.twig',['evenement'=>$evenement]);
          
          $mailer->sendEmail($to,$subject,$html);
     }
            $notifier->send(new Notification('Evenement avec ajouter succées ', ['browser']));


            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }
        else{
            $notifier->send(new Notification('Evenement exist déja  ', ['browser']));
            return $this->redirectToRoute('app_evenement_new', [], Response::HTTP_SEE_OTHER);

        }
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




    #[Route( name: 'test-hadir', methods: ['GET'])]
    public function hadir(Evenement $evenement): Response
    {
      
            return $this->render('evenement/test_hadir.html.twig');
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
    #[Route('/pdf/evenement', name: 'generator_service')]
    public function pdfEvenement(): Response
    { 
        $evenement= $this->getDoctrine()
        ->getRepository(Evenement::class)
        ->findAll();

   

        $html =$this->renderView('pdf/index.html.twig', ['evenement' => $evenement]);
        $pdfGeneratorService=new PdfGeneratorService();
        $pdf = $pdfGeneratorService->generatePdf($html);

        return new Response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="document.pdf"',
        ]);
       
    }





// ...

#[Route('/price/calculate', name: 'evenement_calculate_price', methods: ['POST'])]
// Ajoutez un argument EvenementRepository $evenementRepository à la méthode calculatePrice()
public function calculatePrice(Request $request, EvenementRepository $evenementRepository): Response
{
    $prixt = 20; // Vous pouvez remplacer cette valeur par le prix récupéré de l'événement.
    $number = $request->request->get('number');
    $idev = $request->request->get('idev'); // Récupérez l'ID de l'événement à partir du formulaire
    $evenement = $evenementRepository->find($idev); // Récupérez l'événement à partir de l'ID

    $totalPrice = $prixt * intval($number);

    return $this->render('evenement/test_hadir.html.twig', [
        'evenement' => $evenement,
        'total_price' => $totalPrice,
        'number' => $number,
    ]);
 
}

  #[Route('/{idev}/payer', name: 'payer', methods: ['GET', 'POST'])]
    public function payer(Request $request, MailerInterface $mailer, SnappyPdf $snappy, Ticket $ticket, EntityManagerInterface $entityManager): Response
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
            ->html('<p>Here is the invoice for your Event Tickets (Reférance Ticket: '.$ticket->getIdt().'):</p>')
            ->attachFromPath($pdfFilePath, 'facture.pdf', 'application/pdf');
    
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
        return $this->redirectToRoute('froapp_evenement_indexfrontnt');
    }



}
