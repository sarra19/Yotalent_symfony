<?php

namespace App\Controller;
use App\Entity\Espacetalent;
use App\Entity\Video;
use App\Form\VideoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Entity\Comment;
use App\Form\CommentType;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\VideoRepository;


#[Route('/video')]
class VideoController extends AbstractController
{


    #[Route("/updateVidJSON/{id}", name: "updateVidJSON")]
    public function updateVidJSON(Request $req, $id, NormalizerInterface $normalizer, EntityManagerInterface $entityManager)
    {
        // Find the video entity with the specified id
        $video = $entityManager->getRepository(Video::class)->find($id);
        if (!$video) {
            throw new \Exception('Video not found for id '.$id);
        }
    
        // Get the Espacetalent entity with the specified idEST and set it as the idEST property of the Video entity
        $idEST = $req->get('idEST');
        $espacetalent = $entityManager->getRepository(Espacetalent::class)->find($idEST);
        if (!$espacetalent) {
            throw new \Exception('Espacetalent not found for idEST '.$idEST);
        }
        $video->setIdEST($espacetalent);
    
        // Update the other properties of the Video entity
        $video->setNomVid($req->get('nomVid'));
        $video->setUrl($req->get('url'));
    
        // Persist the changes to the database
        $entityManager->flush();
    
        // Normalize the updated Video entity and return a response
        $jsonContent = $normalizer->normalize($video, 'json', ['groups' => 'videos']);
        return new Response("Video updated successfully " . json_encode($jsonContent));
    }
    
    #[Route("/deleteVidJSON/{id}", name: "deleteVidJSON")]
    public function deleteVidJSON(Request $req, $id, NormalizerInterface $Normalizer)
    {

        $em = $this->getDoctrine()->getManager();
        $video = $em->getRepository(Video::class)->find($id);
        $em->remove($video);
        $em->flush();
        $jsonContent = $Normalizer->normalize($video, 'json', ['groups' => 'videos']);
        return new Response("Video deleted successfully " . json_encode($jsonContent));
    }
    #[Route("/addVidJSON", name: "addVidJSON")]
    public function addVidJSON(Request $req, NormalizerInterface $normalizer): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        
        $video = new Video();
        
        // Get the User entity with the specified idU and set it as the idU property of the Espacetalent entity
       
        
        // Get the Categorie entity with the specified idCat and set it as the idCat property of the Espacetalent entity
        $idEST = $req->get('idEST');
        $espacetalent = $em->getRepository(Espacetalent::class)->find($idEST);
        if (!$espacetalent) {
            throw new \Exception('Espacetalent not found for idEST ' . $idEST);
        }
        $video->setIdest($espacetalent);
        
       $video->setUrl($req->get('url'));
       $video->setNomVid($req->get('nomVid'));
        // Persist and flush the new entity
        $em->persist($video);
        $em->flush();
        
        // Normalize the new entity and return it as a JSON response
        $jsonContent = $normalizer->normalize($video, 'json', ['groups' => 'videos']);
        return new JsonResponse($jsonContent);
    }
    


    
    #[Route("/videoJson/{id}", name: "videoJson")]
    public function VideoId($id, NormalizerInterface $normalizer, VideoRepository $repo)
    {
        $video = $repo->find($id);
        $VideoNormalises = $normalizer->normalize($video, 'json', ['groups' => "videos"]);
        return new Response(json_encode($VideoNormalises));
    }
    #[Route("/AllVideo", name: "listV")]
    //* Dans cette fonction, nous utilisons les services NormlizeInterface et StudentRepository, 
    //* avec la méthode d'injection de dépendances.
    public function getEspace(VideoRepository $repo, SerializerInterface $serializer)
    {
        $videos = $repo->findAll();
        //* Nous utilisons la fonction normalize qui transforme le tableau d'objets 
        //* students en  tableau associatif simple.
        // $studentsNormalises = $normalizer->normalize($students, 'json', ['groups' => "students"]);

        // //* Nous utilisons la fonction json_encode pour transformer un tableau associatif en format JSON
        // $json = json_encode($studentsNormalises);

        $json = $serializer->serialize($videos, 'json', ['groups' => "videos"]);

        //* Nous renvoyons une réponse Http qui prend en paramètre un tableau en format JSON
        return new Response($json);
    }

    #[Route('/', name: 'app_video_index', methods: ['GET'])]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $queryBuilder = $entityManager->createQueryBuilder()
            ->select('e')
            ->from(Video::class, 'e');

       // Advanced search
    $searchQuery = $request->query->get('searchQuery');
    if ($searchQuery) {
        $queryBuilder->andWhere(
            $queryBuilder->expr()->orX(
                $queryBuilder->expr()->like('e.idvid', ':searchQuery'),
                $queryBuilder->expr()->like('e.nomvid', ':searchQuery'),
                $queryBuilder->expr()->like('e.url', ':searchQuery')
            )
        )->setParameter('searchQuery', '%'.$searchQuery.'%');
    }


        // Sorting
        $sort = $request->query->get('sort');
        if ($sort) {
            $queryBuilder->orderBy('e.' . $sort, 'ASC');
        }

        $videos = $queryBuilder->getQuery()->getResult();

        return $this->render('video/index.html.twig', [
            'videos' => $videos,
        ]);
    }


    #[Route('/front', name: 'app_video_indexfront', methods: ['GET'])]
    public function front(EntityManagerInterface $entityManager): Response
    {
        $videos = $entityManager
            ->getRepository(Video::class)
            ->findAll();

        return $this->render('video/index.FrontVV.html.twig', [
            'videos' => $videos,
        ]);
    }

    #[Route('/new', name: 'app_video_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $video = new Video();
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


             // Handle video upload
        $file = $form['url']->getData();
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
            $video->setUrl($fileName);

        }

        $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($video);
            $entityManager->flush();

            return $this->redirectToRoute('app_video_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('video/new.html.twig', [
            'video' => $video,
            'form' => $form,
        ]);
    }

    #[Route('/newV/{idest}', name: 'app_video_newV', methods: ['GET', 'POST'])]
    public function newV(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Get the current Espacetalent entity based on the idest value in the URL
        $idest = $request->attributes->get('idest');
        $espacetalent = $entityManager->getRepository(Espacetalent::class)->find($idest);
    
        if (!$espacetalent) {
            throw $this->createNotFoundException('The Espacetalent entity does not exist');
        }
    
        // Create a new Video entity and set the Espacetalent entity as its parent
        $video = new Video();

        $video->setIdest($espacetalent);
    
        $form = $this->createForm(VidType::class, $video);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Handle video upload
            $file = $form['url']->getData();
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
                $video->setUrl($fileName);
    
            }
    
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($video);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_video_frontest', ['idest' => $idest], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('video/newV.html.twig', [
            'video' => $video,
            'form' => $form,
        ]);
    }
    
    #[Route('/{idvid}', name: 'app_video_show', methods: ['GET'])]
    public function show(Video $video): Response
    {
        return $this->render('video/show.html.twig', [
            'video' => $video,
        ]);
    }

    #[Route('/{idvid}/edit', name: 'app_video_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Video $video, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
             // Handle video upload
        $file = $form['url']->getData();
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
            $video->setUrl($fileName);

        }

        $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('app_video_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('video/edit.html.twig', [
            'video' => $video,
            'form' => $form,
        ]);
    }
  #[Route('/video/front/{idest}', name: 'app_video_frontest', methods: ['GET','POST'], requirements: ['idest' => '\d+'])]
public function frontest(Request $request,EntityManagerInterface $entityManager, $idest = null): Response
{
    $videos = $entityManager
        ->getRepository(Video::class)
        ->findBy(['idest' => $idest]);

    $comment = new Comment();
    $form = $this->createForm(CommentType::class, $comment);
    $form->handleRequest($request);
    $comments = $this->getDoctrine()->getRepository(Comment::class)->findBy(['idest' => $idest]);

    if ($form->isSubmitted() && $form->isValid()) {
        $espaceTalent = $entityManager->getRepository(Espacetalent::class)->find($idest);
        $comment->setIdest($espaceTalent);
        $entityManager->persist($comment);
        $entityManager->flush();
    
        return $this->redirectToRoute('app_video_frontest', ['idest' => $idest]);
    }
    
    return $this->render('video/index.FrontVV.html.twig', [
        'videos' => $videos,
        'form' => $form->createView(),
        'comments' => $comments,
    ]);
}
#[Route('/video/pers/{idest}', name: 'app_video_frontestp', methods: ['GET','POST'], requirements: ['idest' => '\d+'])]
public function frontestp(Request $request,EntityManagerInterface $entityManager, $idest = null): Response
{
    $videos = $entityManager
        ->getRepository(Video::class)
        ->findBy(['idest' => $idest]);

    $comment = new Comment();
    $form = $this->createForm(CommentType::class, $comment);
    $form->handleRequest($request);
    $comments = $this->getDoctrine()->getRepository(Comment::class)->findBy(['idest' => $idest]);

    if ($form->isSubmitted() && $form->isValid()) {
        $espaceTalent = $entityManager->getRepository(Espacetalent::class)->find($idest);
        $comment->setIdest($espaceTalent);
        $entityManager->persist($comment);
        $entityManager->flush();
    
        return $this->redirectToRoute('app_video_frontestp', ['idest' => $idest]);
    }
    
    return $this->render('video/index.FrontV.html.twig', [
        'videos' => $videos,
        'form' => $form->createView(),
        'comments' => $comments,
    ]);
}

    
    
    #[Route('/{idvid}', name: 'app_video_delete', methods: ['POST'])]
    public function delete(Request $request, Video $video, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$video->getIdvid(), $request->request->get('_token'))) {
            $entityManager->remove($video);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_video_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/video/{idvid}', name: 'app_video_deleteV', methods: ['POST'])]
    public function deleteV(Request $request, Video $video, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$video->getIdvid(), $request->request->get('_token'))) {
            $entityManager->remove($video);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_espace_frontu', [], Response::HTTP_SEE_OTHER);
    }

    
   

    


    
}
