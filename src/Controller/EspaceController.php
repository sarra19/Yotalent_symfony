<?php

namespace App\Controller;

use App\Entity\Espacetalent;
use App\Form\EspacetalentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/espace')]
class EspaceController extends AbstractController
{
    #[Route('/', name: 'app_espace_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $espacetalents = $entityManager
            ->getRepository(Espacetalent::class)
            ->findAll();

        return $this->render('espace/index.html.twig', [
            'espacetalents' => $espacetalents,
        ]);
    }

    #[Route('/new', name: 'app_espace_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $espacetalent = new Espacetalent();
        $form = $this->createForm(EspacetalentType::class, $espacetalent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($espacetalent);
            $entityManager->flush();

            return $this->redirectToRoute('app_espace_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('espace/new.html.twig', [
            'espacetalent' => $espacetalent,
            'form' => $form,
        ]);
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
            $entityManager->flush();

            return $this->redirectToRoute('app_espace_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('espace/edit.html.twig', [
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
