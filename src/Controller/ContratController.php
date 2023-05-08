<?php

namespace App\Controller;

use App\Entity\Contrat;
use App\Entity\Espacetalent;

use App\Form\ContratType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Repository\ContratRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
#[Route('/contrat')]
class ContratController extends AbstractController
{

    #[Route("/Allcontrat", name: "listc")]
    //* Dans cette fonction, nous utilisons les services NormlizeInterface et StudentRepository, 
    //* avec la méthode d'injection de dépendances.
    public function getStudents(ContratRepository $repo, SerializerInterface $serializer)
    {
        $contrats = $repo->findAll();
        //* Nous utilisons la fonction normalize qui transforme le tableau d'objets 
        //* students en  tableau associatif simple.
        // $studentsNormalises = $normalizer->normalize($students, 'json', ['groups' => "students"]);
    
        // //* Nous utilisons la fonction json_encode pour transformer un tableau associatif en format JSON
        // $json = json_encode($studentsNormalises);
    
        $json = $serializer->serialize($contrats, 'json', ['groups' => "contrats"]);
    
        //* Nous renvoyons une réponse Http qui prend en paramètre un tableau en format JSON
        return new Response($json);
    }
    
    #[Route("/Contrat/{idc}", name: "contrat")]
    public function StudentId($idc, NormalizerInterface $normalizer, ContratRepository $repo)
    {
        $contrats = $repo->find($idc);
        $contratNormalises = $normalizer->normalize($contrats, 'json', ['groups' => "contrats"]);
        return new Response(json_encode($contratNormalises));
    }
    
    #[Route("/addContratJSON", name: "addContratJSON")]
    public function addContratJSON(Request $req,   NormalizerInterface $Normalizer,EntityManagerInterface $EM)
    {
    
        $contrats = new Contrat();
        //$cont=$EM
        //->getRepository(Contrat::class)
        //->find($req->get('idC'));
        //$voyages->setIdc($cont);
        //$ticket->setNomev($event->getNomev());
        $datedc = new \DateTime(); // create a new DateTime object
$contrats->setDateDC($datedc->format('Y-m-d')); // convert to string and set the value
$datefc = new \DateTime(); // create a new DateTime object
$contrats->setDateFC($datefc->format('Y-m-d')); // convert to string and set the value
$idEST = $req->get('idEST');
$espace = $EM->getRepository(Espacetalent::class)->find($idEST);
if (!$espace) {
    throw new \Exception('espace not found for idEST ' . $idEST);
}
$contrats->setIdEST($espace);
        $contrats->setNomc($req->get('nomC'));
        //$ticket->setNomev($req->get('nomev'));
        //$ticket->setEtat($req->get('etat'));
        $EM->persist($contrats);
        $EM->flush();
        
    
        $jsonContent = $Normalizer->normalize($contrats, 'json', ['groups' => 'contrats']);
        return new Response(json_encode($jsonContent));
    }
    
    #[Route("/updateContratJSON/{id}", name: "updateContratJSON")]
    public function updateContratJSON(Request $req, $id, NormalizerInterface $Normalizer, EntityManagerInterface $EM)
    {
        // Get the Espacetalent entity with the specified id and update its properties
        $contrat = $EM->getRepository(Contrat::class)->find($id);
        if (!$contrat) {
            throw new \Exception('contrat not found for id ' . $id);
        }
    
        // Get the User entity with the specified idU and set it as the idU property of the Espacetalent entity
      
    // Get the Categorie entity with the specified idCat and set it as the idCat property of the Espacetalent entity
    $idEST = $req->get('idEST');
    $espace = $EM->getRepository(Espacetalent::class)->find($idEST);
    if (!$espace) {
        throw new \Exception('espace not found for idCat ' . $idEST);
    }
    $contrat->setIdEST($espace);
        
    
        // Update the other properties of the Espacetalent entity
        $contrat->setNomc($req->get('nomC'));
        
        $contrat->setDatedc($req->get('DateDC'));
        $contrat->setDatefc($req->get('DateFC'));
    
        // Persist the changes to the database
        $EM->flush();
    
        // Normalize the updated Espacetalent entity and return a response
        $jsonContent = $Normalizer->normalize($contrat, 'json', ['groups' => 'contrats']);
        return new Response("contrat updated successfully " . json_encode($jsonContent));
    }
    #[Route("/deleteContratJSON/{id}", name: "deleteContratJSON")]
    public function deleteVidJSON(Request $req, $id, NormalizerInterface $Normalizer)
    {

        $em = $this->getDoctrine()->getManager();
        $contrat = $em->getRepository(Contrat::class)->find($id);
        $em->remove($contrat);
        $em->flush();
        $jsonContent = $Normalizer->normalize($contrat, 'json', ['groups' => 'contrats']);
        return new Response("contrat deleted successfully " . json_encode($jsonContent));
    }
    
    #[Route('/', name: 'app_contrat_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $contrats = $entityManager
            ->getRepository(Contrat::class)
            ->findAll();

        return $this->render('contrat/index.html.twig', [
            'contrats' => $contrats,
        ]);
    }

    #[Route('/new', name: 'app_contrat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contrat = new Contrat();
        $form = $this->createForm(ContratType::class, $contrat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contrat);
            $entityManager->flush();

            return $this->redirectToRoute('app_contrat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contrat/new.html.twig', [
            'contrat' => $contrat,
            'form' => $form,
        ]);
    }
    #[Route('/front', name: 'app_contrat_indexfront', methods: ['GET'])]
    public function front(EntityManagerInterface $entityManager): Response
    {
        $contrats = $entityManager
            ->getRepository(Contrat::class)
            ->findAll();

        return $this->render('contrat/indexFront.html.twig', [
            'contrats' => $contrats,
        ]);
    }

    #[Route('/{idc}', name: 'app_contrat_show', methods: ['GET'])]
    public function show(Contrat $contrat): Response
    {
        return $this->render('contrat/show.html.twig', [
            'contrat' => $contrat,
        ]);
    }

    #[Route('/{idc}/edit', name: 'app_contrat_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Contrat $contrat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContratType::class, $contrat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_contrat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contrat/edit.html.twig', [
            'contrat' => $contrat,
            'form' => $form,
        ]);
    }

    #[Route('/{idc}', name: 'app_contrat_delete', methods: ['POST'])]
    public function delete(Request $request, Contrat $contrat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contrat->getIdc(), $request->request->get('_token'))) {
            $entityManager->remove($contrat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_contrat_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
 * @Route("/api/pdfasma", name="pdfasma", methods={"GET"})
 */
public function generatePdf(EntityManagerInterface $entityManager): Response
{
    $contrats = $entityManager
    ->getRepository(Contrat::class)
    ->findAll();
    $options = new Options();
    $options->set('defaultFont', 'Arial');
    $dompdf = new Dompdf($options);

    $html = $this->renderView('pdf/pdf.html.twig', ['contrats' => $contrats]);


    $dompdf->loadHtml($html);
    $dompdf->render();

    $output = $dompdf->output();

    $response = new Response($output);
    $response->headers->set('Content-Type', 'application/pdf');
    $response->headers->set('Content-Disposition', 'attachment; filename="pdf.pdf"');

    return $response;
}

#[Route('/contrat/email', name: 'app')]
    public function envoyerEmail(Request $request, MailerInterface $mailer)
    {
        if ($request->isMethod('POST')) {
            $expediteur = $request->request->get('expediteur');
            $destinataire = 'asma.glenza@esprit.tn';
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

}