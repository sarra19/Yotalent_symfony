<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    /**
     * @Route("/comment", name="comment_new", methods={"GET","POST"})
     */
    public function new(Request $request)
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('comment_list');
        }

        return $this->render('video/index.FrontVV.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }

    
#[Route('/list', name: 'comment_list', methods: ['GET'])]
    public function list()
    {
        $comments = $this->getDoctrine()->getRepository(Comment::class)->findAll();

        return $this->render('video/index.FrontVV.html.twig', [
            'comments' => $comments,
        ]);
    }
}
?>