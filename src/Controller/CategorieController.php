<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use App\Repository\CatRepository;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/categorie')]
class CategorieController extends AbstractController
{

    
    #[Route("/updateCatJSON/{idcat}", name: "updateCatJSON")]
    public function updateCatJSON(Request $req, $idcat, NormalizerInterface $Normalizer)
    {

        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository(Categorie::class)->find($idcat);
        $category->setNomcat($req->get('nomCat'));

        $em->flush();

        $jsonContent = $Normalizer->normalize($category, 'json', ['groups' => 'categories']);
        return new Response("Category updated successfully " . json_encode($jsonContent));
    }

    #[Route("/deleteCatJSON/{id}", name: "deleteCatJSON")]
    public function deleteCatJSON(Request $req, $id, NormalizerInterface $Normalizer)
    {

        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository(Categorie::class)->find($id);
        $em->remove($category);
        $em->flush();
        $jsonContent = $Normalizer->normalize($category, 'json', ['groups' => 'categories']);
        return new Response("Category deleted successfully " . json_encode($jsonContent));
    }
    
    #[Route("/addCatJSON", name: "addCatJSON")]
    public function addCatJSON(Request $req, NormalizerInterface $Normalizer)
    {
        $em = $this->getDoctrine()->getManager();
    
        // validate the input
        $validator = Validation::createValidator();
        $violations = $validator->validate($req->get('nomCat'), [
            new Length(['min' => 5, 'minMessage' => 'The category name must be at least {{ limit }} characters.']),
        ]);
        if (count($violations) > 0) {
            $errors = [];
            foreach ($violations as $violation) {
                $errors[$violation->getPropertyPath()][] = $violation->getMessage();
            }
            return new JsonResponse(['errors' => $errors], Response::HTTP_BAD_REQUEST);
        }
    
        $category = new Categorie();
        $category->setNomcat($req->get('nomCat'));
        $em->persist($category);
        $em->flush();
    
        $jsonContent = $Normalizer->normalize($category, 'json', ['groups' => 'categories']);
        return new Response(json_encode($jsonContent));
    }
    

    
    #[Route("/Category/{idcat}", name: "category")]
    public function CategoryId($idcat, NormalizerInterface $normalizer, CatRepository $repo)
    {
        $category = $repo->find($idcat);
        $categoryNormalises = $normalizer->normalize($category, 'json', ['groups' => "categories"]);
        return new Response(json_encode($categoryNormalises));
    }
    #[Route("/AllCategory", name: "listS")]
    //* Dans cette fonction, nous utilisons les services NormlizeInterface et StudentRepository, 
    //* avec la méthode d'injection de dépendances.
    public function getCategory(CatRepository $repo, SerializerInterface $serializer)
    {
        $students = $repo->findAll();
        //* Nous utilisons la fonction normalize qui transforme le tableau d'objets 
        //* students en  tableau associatif simple.
        // $studentsNormalises = $normalizer->normalize($students, 'json', ['groups' => "students"]);

        // //* Nous utilisons la fonction json_encode pour transformer un tableau associatif en format JSON
        // $json = json_encode($studentsNormalises);

        $json = $serializer->serialize($students, 'json', ['groups' => "categories"]);

        //* Nous renvoyons une réponse Http qui prend en paramètre un tableau en format JSON
        return new Response($json);
    }

    #[Route('/', name: 'app_categorie_index', methods: ['GET'])]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $queryBuilder = $entityManager->createQueryBuilder()
            ->select('e')
            ->from(Categorie::class, 'e');

       // Advanced search
    $searchQuery = $request->query->get('searchQuery');
    if ($searchQuery) {
        $queryBuilder->andWhere(
            $queryBuilder->expr()->orX(
                $queryBuilder->expr()->like('e.idcat', ':searchQuery'),
                $queryBuilder->expr()->like('e.nomcat', ':searchQuery'),
            )
        )->setParameter('searchQuery', '%'.$searchQuery.'%');
    }

        // Sorting
        $sort = $request->query->get('sort');
        if ($sort) {
            $queryBuilder->orderBy('e.' . $sort, 'ASC');
        }

        $categories = $queryBuilder->getQuery()->getResult();

        return $this->render('categorie/index.html.twig', [
            'categories' => $categories,
        ]);
    }



    #[Route('/front', name: 'app_categorie_indexfront', methods: ['GET'])]
    public function front(EntityManagerInterface $entityManager): Response
    {
        $categories = $entityManager
            ->getRepository(Categorie::class)
            ->findAll();

        return $this->render('categorie/indexFront.html.twig', [
            'categories' => $categories,
        ]);
    }
    
    #[Route('/frontA', name: 'app_categorie_indexfrontA', methods: ['GET'])]
    public function frontA(EntityManagerInterface $entityManager): Response
    {
        $categories = $entityManager
            ->getRepository(Categorie::class)
            ->findAll();

        return $this->render('categorie/indexFrontA.html.twig', [
            'categories' => $categories,
        ]);
    }
    
    #[Route('/frontC', name: 'app_categorie', methods: ['GET'])]
    public function frontC(EntityManagerInterface $entityManager): Response
    {
        $categories = $entityManager
            ->getRepository(Categorie::class)
            ->findAll();

        return $this->render('contrat/indexFrontC.html.twig', [
            'categories' => $categories,
        ]);
    }
    

    #[Route('/new', name: 'app_categorie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categorie);
            $entityManager->flush();

            return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categorie/new.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
        ]);
    }


    #[Route('/{idcat}', name: 'app_categorie_show', methods: ['GET'])]
    public function show(Categorie $categorie): Response
    {
        return $this->render('categorie/show.html.twig', [
            'categorie' => $categorie,
        ]);
    }

    #[Route('/{idcat}/edit', name: 'app_categorie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Categorie $categorie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categorie/edit.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
        ]);
    }

    #[Route('/{idcat}', name: 'app_categorie_delete', methods: ['POST'])]
    public function delete(Request $request, Categorie $categorie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorie->getIdcat(), $request->request->get('_token'))) {
            $entityManager->remove($categorie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);
    }


    
}
