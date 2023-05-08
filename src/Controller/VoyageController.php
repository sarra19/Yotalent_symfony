<?php

namespace App\Controller;
use App\Entity\Voyage;
use App\Entity\Contrat;
use App\Repository\VoyageRepository;
use Symfony\Component\Serializer\SerializerInterface;
use App\Form\VoyageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/voyage')]
class VoyageController extends AbstractController
{
    #[Route("/Allvoyage", name: "listv")]
    //* Dans cette fonction, nous utilisons les services NormlizeInterface et StudentRepository, 
    //* avec la méthode d'injection de dépendances.
    public function getStudents(VoyageRepository $repo, SerializerInterface $serializer)
    {
        $voyages = $repo->findAll();
        //* Nous utilisons la fonction normalize qui transforme le tableau d'objets 
        //* students en  tableau associatif simple.
        // $studentsNormalises = $normalizer->normalize($students, 'json', ['groups' => "students"]);
    
        // //* Nous utilisons la fonction json_encode pour transformer un tableau associatif en format JSON
        // $json = json_encode($studentsNormalises);
    
        $json = $serializer->serialize($voyages, 'json', ['groups' => "voyages"]);
    
        //* Nous renvoyons une réponse Http qui prend en paramètre un tableau en format JSON
        return new Response($json);
    }
    
    #[Route("/Voyage/{idvoy}", name: "voyage")]
    public function StudentId($idvoy, NormalizerInterface $normalizer, VoyageRepository $repo)
    {
        $voyages = $repo->find($idvoy);
        $voyageNormalises = $normalizer->normalize($voyages, 'json', ['groups' => "voyages"]);
        return new Response(json_encode($voyageNormalises));
    }
    
    #[Route("/addVoyageJSON", name: "addVoyageJSON")]
    public function addVoyageJSON(Request $req,   NormalizerInterface $Normalizer,EntityManagerInterface $EM)
    {
    
        $voyages = new Voyage();
        //$cont=$EM
        //->getRepository(Contrat::class)
        //->find($req->get('idC'));
        //$voyages->setIdc($cont);
        //$ticket->setNomev($event->getNomev());
       $datedvoy = new \DateTime(); // create a new DateTime object
$voyages->setDateDVoy($datedvoy->format('Y-m-d')); // convert to string and set the value
$datervoy = new \DateTime(); // create a new DateTime object
$voyages->setDateRVoy($datervoy->format('Y-m-d')); // convert to string and set the value
$idC = $req->get('idC');
$contrat = $EM->getRepository(Contrat::class)->find($idC);
if (!$contrat) {
    throw new \Exception('contrat not found for idC ' . $idC);
}
$voyages->setIdC($contrat);
        $voyages->setDestination($req->get('destination'));
        //$ticket->setNomev($req->get('nomev'));
        //$ticket->setEtat($req->get('etat'));
        $EM->persist($voyages);
        $EM->flush();
        
    
        $jsonContent = $Normalizer->normalize($voyages, 'json', ['groups' => 'voyages']);
        return new Response(json_encode($jsonContent));
    }
    #[Route('/piechart', name: 'voyage_piechart')]
public function piechart(EntityManagerInterface $em): JsonResponse
{
    // Les destinations à prendre en compte
    $destinations = ['Tunis', 'Bizerte', 'Sousse'];

    // Récupérer les données des voyages
    $repo = $em->getRepository(Voyage::class);
    $builder = $repo->createQueryBuilder('v')
        ->select('v.destination, COUNT(v.idvoy) as total')
        ->andWhere('v.destination IN (:destinations)')
        ->setParameter('destinations', $destinations)
        ->groupBy('v.destination');
    $data = $builder->getQuery()->getResult();

    // Transformer les données en un tableau pour le diagramme circulaire
    $chartData = [];
    foreach ($data as $row) {
        $chartData[] = [
            'label' => $row['destination'],
            'value' => (int) $row['total']
        ];
    }

    // Créer la réponse JSON contenant les données pour le diagramme circulaire
    $response = new JsonResponse();
    $response->setData($chartData);

    return $response;
}
    
    #[Route("/updateVoyageJSON/{id}", name: "updateVoyageJSON")]
    public function updateVoyageJSON(Request $req, $id, NormalizerInterface $Normalizer, EntityManagerInterface $EM)
    {
        // Get the Espacetalent entity with the specified id and update its properties
        $voyage = $EM->getRepository(Voyage::class)->find($id);
        if (!$voyage) {
            throw new \Exception('voyage not found for id ' . $id);
        }
    
        // Get the User entity with the specified idU and set it as the idU property of the Espacetalent entity
      
    // Get the Categorie entity with the specified idCat and set it as the idCat property of the Espacetalent entity
    $idC = $req->get('idC');
    $contrat = $EM->getRepository(Contrat::class)->find($idC);
    if (!$contrat) {
        throw new \Exception('contrat not found for idCat ' . $idC);
    }
    $voyage->setIdC($contrat);
        
    
        // Update the other properties of the Espacetalent entity

        $voyage->setDatedvoy($req->get('dateDVoy'));
        $voyage->setDatervoy($req->get('dateRVoy'));
        $voyage->setDestination($req->get('destination'));

        // Persist the changes to the database
        $EM->flush();
    
        // Normalize the updated Espacetalent entity and return a response
        $jsonContent = $Normalizer->normalize($voyage, 'json', ['groups' => 'voyages']);
        return new Response("voyage updated successfully " . json_encode($jsonContent));
    }
    
    #[Route("/deleteVoyageJSON/{id}", name: "deleteVoyageJSON")]
    public function deleteVidJSON(Request $req, $id, NormalizerInterface $Normalizer)
    {

        $em = $this->getDoctrine()->getManager();
        $voyage = $em->getRepository(Voyage::class)->find($id);
        $em->remove($voyage);
        $em->flush();
        $jsonContent = $Normalizer->normalize($voyage, 'json', ['groups' => 'voyages']);
        return new Response("voyage deleted successfully " . json_encode($jsonContent));
    }
    





    #[Route('/show_in_map/{idvoy}', name: 'app_voy_map', methods: ['GET'])]
    public function Map( Voyage $idvoy,EntityManagerInterface $entityManager ): Response
    {
    
        $idvoy = $entityManager
            ->getRepository(Voyage::class)->findBy( 
                ['idvoy'=>$idvoy ]
            );
        return $this->render('Voyage/api_arcgis.html.twig', [
            'Voyage' => $idvoy,
        ]);
    }
    
    



    #[Route('/', name: 'app_voyage_index', methods: ['GET'])]
public function index(Request $request, EntityManagerInterface $entityManager): Response
{
    $queryBuilder = $entityManager->createQueryBuilder()
        ->select('e')
        ->from(Voyage::class, 'e');

    // Advanced search
    $searchQuery = $request->query->get('searchQuery');
    if ($searchQuery) {
        $queryBuilder->andWhere(
            $queryBuilder->expr()->orX(
                $queryBuilder->expr()->like('e.idvoy', ':searchQuery'),
                $queryBuilder->expr()->like('e.datedvoy', ':searchQuery'),
                $queryBuilder->expr()->like('e.datervoy', ':searchQuery')
            )
        )->setParameter('searchQuery', '%'.$searchQuery.'%');
    }









    // Sorting
    $sort = $request->query->get('sort');
    if ($sort) {
        $queryBuilder->orderBy('e.' . $sort, 'ASC');
    }

    $voyages = $queryBuilder->getQuery()->getResult();

    return $this->render('voyage/index.html.twig', [
        'voyages' => $voyages,
    ]);
}

    #[Route('/new', name: 'app_voyage_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $voyage = new Voyage();
        $form = $this->createForm(VoyageType::class, $voyage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($voyage);
            $entityManager->flush();

            return $this->redirectToRoute('app_voyage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('voyage/new.html.twig', [
            'voyage' => $voyage,
            'form' => $form,
        ]);
    }

    #[Route('/{idvoy}', name: 'app_voyage_show', methods: ['GET'])]
    public function show(Voyage $voyage): Response
    {
        return $this->render('voyage/show.html.twig', [
            'voyage' => $voyage,
        ]);
    }

    #[Route('/{idvoy}/edit', name: 'app_voyage_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Voyage $voyage, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VoyageType::class, $voyage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_voyage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('voyage/edit.html.twig', [
            'voyage' => $voyage,
            'form' => $form,
        ]);
    }

    #[Route('/{idvoy}', name: 'app_voyage_delete', methods: ['POST'])]
    public function delete(Request $request, Voyage $voyage, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$voyage->getIdvoy(), $request->request->get('_token'))) {
            $entityManager->remove($voyage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_voyage_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/voyage/front', name: 'app_voyage_front', methods: ['GET'])]
    public function front(EntityManagerInterface $entityManager): Response
    {
        $voyages = $entityManager
            ->getRepository(Voyage::class)
            ->findAll();

        return $this->render('voyage/indexFront.html.twig', [
            'voyages' => $voyages,
        ]);
    }
    #[Route('/voyage/front/{idc}', name: 'app_voyage_frontc', methods: ['GET'], requirements: ['idc' => '\d+'])]
public function frontc(EntityManagerInterface $entityManager, $idc = null): Response
{
    $voyages = $entityManager
        ->getRepository(Voyage::class)
        ->findBy(['idc' => $idc]);

    return $this->render('voyage/indexFront.html.twig', [
        'voyages' => $voyages,
    ]);
    
}

/**
 * @Route("/voyage/statistiques", name="app_voyage_stats")
 */
public function stats(): Response
{
    // Récupérer tous les voyages depuis la base de données
    $voyages = $this->getDoctrine()->getRepository(Voyage::class)->findAll();

    // Filtrer les voyages par destination
    $tunis_voyages = array_filter($voyages, function($voyage) {
        return $voyage->getDestination() === 'Tunis';
    });
    $bizerte_voyages = array_filter($voyages, function($voyage) {
        return $voyage->getDestination() === 'Bizerte';
    });
    $sousse_voyages = array_filter($voyages, function($voyage) {
        return $voyage->getDestination() === 'Sousse';
    });

    // Rendre la vue contenant les statistiques
    return $this->render('Stat/index.html.twig', [
        'tunis_voyages' => $tunis_voyages,
        'bizerte_voyages' => $bizerte_voyages,
        'sousse_voyages' => $sousse_voyages,
    ]);




}

}