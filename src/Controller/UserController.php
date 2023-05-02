<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\CategorieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{
  
   
    #[Route('/login', name: 'login', methods: ['GET'])]
public function index(Request $request, EntityManagerInterface $entityManager): Response
{
    return $this->render('user/login.html.twig');
}

}