<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Espacetalent;
use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Form\EspacetalentType;
use App\Form\EspaceType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Knp\Component\Pager\PaginatorInterface;

use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use App\Repository\EspaceRepository;


#[Route('/espace')]
class EspaceController extends AbstractController
{
  
   
    #[Route("/updateEspJSON/{id}", name: "updateEspJSON")]
    public function updateEspJSON(Request $req, $id, NormalizerInterface $Normalizer, EntityManagerInterface $EM)
    {
        // Get the Espacetalent entity with the specified id and update its properties
        $espace = $EM->getRepository(Espacetalent::class)->find($id);
        if (!$espace) {
            throw new \Exception('Espacetalent not found for id ' . $id);
        }
    
        // Get the User entity with the specified idU and set it as the idU property of the Espacetalent entity
        $idU = $req->get('idU');
        $user = $EM->getRepository(User::class)->find($idU);
        if (!$user) {
            throw new \Exception('User not found for idU ' . $idU);
        }
        $espace->setIdU($user);
    
        // Get the Categorie entity with the specified idCat and set it as the idCat property of the Espacetalent entity
        $idCat = $req->get('idCat');
        $categorie = $EM->getRepository(Categorie::class)->find($idCat);
        if (!$categorie) {
            throw new \Exception('Categorie not found for idCat ' . $idCat);
        }
        $espace->setIdCat($categorie);
    
        // Update the other properties of the Espacetalent entity
        $espace->setUsername($req->get('username'));
        $espace->setImage($req->get('image'));
        $espace->setNbVotes($req->get('nbVotes'));
    
        // Persist the changes to the database
        $EM->flush();
    
        // Normalize the updated Espacetalent entity and return a response
        $jsonContent = $Normalizer->normalize($espace, 'json', ['groups' => 'espacetalents']);
        return new Response("Espacetalent updated successfully " . json_encode($jsonContent));
    }
    


    #[Route("/deleteEspJSON/{id}", name: "deleteEspJSON")]
    public function deleteEspJSON(Request $req, $id, NormalizerInterface $Normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $espacetalent = $em->getRepository(Espacetalent::class)->find($id);
        $em->remove($espacetalent);
        $em->flush();
        $jsonContent = $Normalizer->normalize($espacetalent, 'json', ['groups' => 'espacetalents']);
        return new Response("espacetalent deleted successfully " . json_encode($jsonContent));
    }
    
    
    #[Route("/addEstJSON", name: "addEstJSON")]
    public function addEstJSON(Request $req, NormalizerInterface $normalizer): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        
        $espacetalent = new Espacetalent();
        
        // Get the User entity with the specified idU and set it as the idU property of the Espacetalent entity
        $idU = $req->get('idU');
        $user = $em->getRepository(User::class)->find($idU);
        if (!$user) {
            throw new \Exception('User not found for idU ' . $idU);
        }
        $espacetalent->setIdU($user);
        
        // Get the Categorie entity with the specified idCat and set it as the idCat property of the Espacetalent entity
        $idCat = $req->get('idCat');
        $categorie = $em->getRepository(Categorie::class)->find($idCat);
        if (!$categorie) {
            throw new \Exception('Categorie not found for idCat ' . $idCat);
        }
        $espacetalent->setIdCat($categorie);
        
        // Set the other properties of the Espacetalent entity
        $espacetalent->setUsername($req->get('username'));
        $espacetalent->setImage($req->get('image'));
        $espacetalent->setNbVotes($req->get('nbVotes'));
        
        // Persist and flush the new entity
        $em->persist($espacetalent);
        $em->flush();
        
        // Normalize the new entity and return it as a JSON response
        $jsonContent = $normalizer->normalize($espacetalent, 'json', ['groups' => 'espacetalents']);
        return new JsonResponse($jsonContent);
    }
    



    
    #[Route("/space/{id}", name: "espacetalent")]
    public function EspaceId($id, NormalizerInterface $normalizer, EspaceRepository $repo)
    {
        $espacetalent = $repo->find($id);
        $espaceNormalises = $normalizer->normalize($espacetalent, 'json', ['groups' => "espacetalents"]);
        return new Response(json_encode($espaceNormalises));
    }
    #[Route("/AllEspace", name: "listEsp")]
    //* Dans cette fonction, nous utilisons les services NormlizeInterface et StudentRepository, 
    //* avec la méthode d'injection de dépendances.
    public function getEspace(EspaceRepository $repo, SerializerInterface $serializer)
    {
        $espaces = $repo->findAll();
        //* Nous utilisons la fonction normalize qui transforme le tableau d'objets 
        //* students en  tableau associatif simple.
        // $studentsNormalises = $normalizer->normalize($students, 'json', ['groups' => "students"]);

        // //* Nous utilisons la fonction json_encode pour transformer un tableau associatif en format JSON
        // $json = json_encode($studentsNormalises);

        $json = $serializer->serialize($espaces, 'json', ['groups' => "espacetalents"]);

        //* Nous renvoyons une réponse Http qui prend en paramètre un tableau en format JSON
        return new Response($json);
    }


   
    #[Route('/', name: 'app_espace_index', methods: ['GET'])]
public function index(Request $request, EntityManagerInterface $entityManager,PaginatorInterface $paginator): Response
{
    $queryBuilder = $entityManager->createQueryBuilder()
        ->select('e')
        ->from(Espacetalent::class, 'e');

          $espacetalents = $entityManager
            ->getRepository(Espacetalent::class)
            ->findAll();
    // Advanced search
    $searchQuery = $request->query->get('searchQuery');
    if ($searchQuery) {
        $queryBuilder->andWhere(
            $queryBuilder->expr()->orX(
                $queryBuilder->expr()->like('e.username', ':searchQuery'),
                $queryBuilder->expr()->like('e.nbvotes', ':searchQuery'),
                $queryBuilder->expr()->like('e.idest', ':searchQuery')
            )
        )->setParameter('searchQuery', '%'.$searchQuery.'%');
    }

    // Sorting
    $sort = $request->query->get('sort');
    if ($sort) {
        $queryBuilder->orderBy('e.' . $sort, 'ASC');
    }

    $espacetalents = $queryBuilder->getQuery()->getResult();

    //pagination
    $pagination = $paginator->paginate(
        $espacetalents,
        $request->query->getInt('page', 1), 7
    );

        return $this->render('espace/index.html.twig', [
            'pagination' => $pagination,
                    'espacetalents' => $espacetalents,

        ]);
    // return $this->render('espace/index.html.twig', [
    //     'espacetalents' => $espacetalents,
    // ]);
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

#[Route('/espace/frontA/{idcat}', name: 'app_espace_max', methods: ['GET'], requirements: ['idcat' => '\d+'])]
public function frontcatmax(EntityManagerInterface $entityManager, $idcat = null): Response
{
$espacetalents = $entityManager
->getRepository(Espacetalent::class)
->findBy(['idcat' => $idcat], ['nbvotes' => 'DESC'], 1);
return $this->render('espace/indexFA.html.twig', [
    'espacetalents' => $espacetalents,
]);
}


 
  
#[Route('/espace/front/{idcat}', name: 'app_espace', methods: ['GET'], requirements: ['idcat' => '\d+'])]
public function frontcattt(EntityManagerInterface $entityManager, $idcat = 1111): Response
{
    $espacetalents = $entityManager
        ->getRepository(Espacetalent::class)
        ->findBy(['idcat' => $idcat]);
    
    return $this->render('contrat/index.FrontEE.html.twig', [
        'espacetalents' => $espacetalents,
    ]);
}
 

   
#[Route('/pdfs', name: 'api_generate_pdfs', methods: ['GET'])]
public function generatePdf(EntityManagerInterface $entityManager): Response
{
    $espacetalents = $entityManager
    ->getRepository(Espacetalent::class)
    ->findAll();
    $options = new Options();
    $options->set('defaultFont', 'Arial');
    $dompdf = new Dompdf($options);

    $html = $this->renderView('Stat/pdfs.html.twig', ['espacetalents' => $espacetalents]);


    $dompdf->loadHtml($html);
    $dompdf->render();

    $output = $dompdf->output();

    $response = new Response($output);
    $response->headers->set('Content-Type', 'application/pdf');
    $response->headers->set('Content-Disposition', 'attachment; filename="pdf.pdf"');

    return $response;
}


#[Route('/piechart', name: 'piechart')]
public function piechart(EspaceRepository $repo): JsonResponse
{
    // Query the database to get the number of votes for each Espacetalent object
    $espacetalents = $repo->findAll();
    $votes = array_map(function($espacetalent) {
        return $espacetalent->getNbVotes();
    }, $espacetalents);

    // Group the votes into different intervals
    $intervalCounts = [
        '0-10' => 0,
        '10-20' => 0,
        '20-50' => 0
    ];
    foreach ($votes as $vote) {
        if ($vote >= 0 && $vote <= 10) {
            $intervalCounts['0-10']++;
        } else if ($vote > 10 && $vote <= 20) {
            $intervalCounts['10-20']++;
        } else if ($vote > 20 && $vote <= 50) {
            $intervalCounts['20-50']++;
        }
    }

    // Format the data for the pie chart
    $data = [];
    foreach ($intervalCounts as $interval => $count) {
        $data[] = [
            'label' => $interval,
            'value' => $count
        ];
    }

    // Return the data as a JSON response
    $response = new JsonResponse();
    $response->setData($data);

    return $response;
}

 
#[Route('/pdf/espace', name: 'generator_servicet')]
public function pdfest(): Response
{ 
    $espacetalents = $this->getDoctrine()
->getRepository(Espacetalent::class)
->findAll();



   $html = $this->renderView('Stat/pdfs.html.twig', ['espacetalents' => $espacetalents]);
    $pdfGeneratorService=new PdfGeneratorService();
    $pdf = $pdfGeneratorService->generatePdf($html);

    return new Response($pdf, 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="document.pdf"',
    ]);
   
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

  /**
     * @Route("/espace/stat", name="app_stat_index")
     */
    public function stat(EspaceRepository $repository, EntityManagerInterface $entityManager): Response
    {
        $espacetalents = $entityManager
    ->getRepository(Espacetalent::class)
    ->findAll();
        $counts = $repository->countByVoteIntervals([0, 10, 20, 50]);
        $total = array_sum($counts);
        $percentages = [];
        foreach ($counts as $count) {
            $percentages[] = round($count / $total * 100, 2);
        }
        return $this->render('Stat/StatS.html.twig', [
            'counts' => $counts,
            'percentages' => $percentages,
            'total' => $total,
            'espacetalents' => $espacetalents,
        ]);
    }


    #[Route('/new', name: 'app_espace_new', methods: ['GET', 'POST'])]
    public function new(Request $request,MailerInterface $mailer, EntityManagerInterface $entityManager): Response
{
      
        $espacetalent = new Espacetalent();
        $espacetalent->setNbvotes(0); 
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

         return $this->redirectToRoute('app_espace_index', [], Response::HTTP_SEE_OTHER);

         //   $notifier->send(new Notification('EspaceTalent  ajouter avec succées ', ['browser']));
        }

        return $this->renderForm('espace/new.html.twig', [
            'espacetalent' => $espacetalent,
            'form' => $form,
        ]);
    }
      
    #[Route('/front/{idu}', name: 'app_espace_frontu', methods: ['GET'], requirements: ['idu' => '\d+'])]
    public function frontu(Request $request, EntityManagerInterface $entityManager, $idu = 1): Response
    {
        $espacetalents = $entityManager
            ->getRepository(Espacetalent::class)
            ->findBy(['idu' => $idu]);
    
    
    
        return $this->render('espace/index.FrontE.html.twig', [
            'espacetalents' => $espacetalents,
            'idu' => $idu,
        ]);
    }
    
    #[Route('/espacetalent/like', name: 'app_espacetalent_like', methods: ['POST'])]
    public function like(Request $request, EntityManagerInterface $entityManager, FlashBagInterface $flashBag): Response
    {
        $idest = $request->request->get('idest');
        $espacetalent = $entityManager->getRepository(Espacetalent::class)->find($idest);
        if (!$espacetalent) {
            throw $this->createNotFoundException('Espacetalent not found');
        }
        $espacetalent->setNbvotes($espacetalent->getNbvotes() + 1);
        $entityManager->flush();
    
        $flashBag->add('success', 'Vote pris en compte !');
    
        return $this->redirectToRoute('app_espace_frontcatt');
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
    $espacetalent->setNbvotes(0); 


    $form = $this->createForm(EspaceType::class, $espacetalent);
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

    
    #[Route('/espace/{idest}/edit', name: 'app_espace_edit', methods: ['GET', 'POST'])]
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
        $form = $this->createForm(EspaceType::class, $espacetalent);
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
    
    
#[Route('/espace/front/{idcat}', name: 'app_espace_frontcatt', methods: ['GET'], requirements: ['idcat' => '\d+'])]
public function frontcatt(EntityManagerInterface $entityManager, $idcat = 1111): Response
{
    $espacetalents = $entityManager
        ->getRepository(Espacetalent::class)
        ->findBy(['idcat' => $idcat]);
    
    return $this->render('espace/index.FrontEE.html.twig', [
        'espacetalents' => $espacetalents,
    ]);
}
 
   
    
    
    
}
