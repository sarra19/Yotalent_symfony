<?php

namespace App\Controller;

use App\Entity\User;
<<<<<<< HEAD
use App\Form\UserType;
use App\Repository\UserRepository;
=======
use App\Form\CategorieType;
use Doctrine\ORM\EntityManagerInterface;
>>>>>>> New/integ
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
<<<<<<< HEAD
use BaconQrCode\Renderer\Image\Png;
use BaconQrCode\Writer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
//        $user = $this->getUser();

        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }

    public function generate_qr_code(User $user)
    {
        $renderer = new Png();
        $renderer->setHeight(256);
        $renderer->setWidth(256);

        $writer = new Writer($renderer);
        $qrCode = $writer->writeString('User ID: ' . $user->getId() . ', Email: ' . $user->getEmail());

        return 'data:image/png;base64,' . base64_encode($qrCode);
    }

    
    #[Route('/r/search_user', name: 'search_user', methods: ['GET'])]
    public function search_user(Request $request, NormalizerInterface $Normalizer, UserRepository $userRepository): Response
    {

        $requestString = $request->get('searchValue');
        $requestString3 = $request->get('orderid');

        $user = $userRepository->findUser($requestString, $requestString3);
        $jsoncontentc = $Normalizer->normalize($user, 'json', ['users' => 'posts:read']);
        $jsonc = json_encode($jsoncontentc);
        if ($jsonc == "[]") {
            return new Response(null);
        } else {
            return new Response($jsonc);
        }
    }
    
}
=======


class UserController extends AbstractController
{
  
   
    #[Route('/login', name: 'login', methods: ['GET'])]
public function index(Request $request, EntityManagerInterface $entityManager): Response
{
    return $this->render('user/login.html.twig');
}


#[Route('/', name: 'accueila', methods: ['GET'])]
public function indexaa(Request $request, EntityManagerInterface $entityManager): Response
{
    return $this->render('Front.html.twig');
}


}
>>>>>>> New/integ
