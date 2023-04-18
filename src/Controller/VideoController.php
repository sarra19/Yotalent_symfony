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

#[Route('/video')]
class VideoController extends AbstractController
{
    #[Route('/', name: 'app_video_index', methods: ['GET'])]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $queryBuilder = $entityManager->createQueryBuilder()
            ->select('e')
            ->from(Video::class, 'e');

        // Basic search by username or nbvotes
        $searchQuery = $request->query->get('search');
        if ($searchQuery) {
            $queryBuilder->andWhere($queryBuilder->expr()->orX(
                $queryBuilder->expr()->like('e.idvid', ':searchQuery'),
                $queryBuilder->expr()->eq('e.nomvid', ':searchQuery'),
                $queryBuilder->expr()->eq('e.url', ':searchQuery'),

            ))
            ->setParameter('searchQuery', $searchQuery);
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
    #[Route('/video/front/{idest}', name: 'app_video_frontest', methods: ['GET'], requirements: ['idest' => '\d+'])]
    public function frontest(EntityManagerInterface $entityManager, $idest = null): Response
    {
        $videos = $entityManager
            ->getRepository(Video::class)
            ->findBy(['idest' => $idest]);
    
        return $this->render('video/index.FrontVV.html.twig', [
            'videos' => $videos,
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
