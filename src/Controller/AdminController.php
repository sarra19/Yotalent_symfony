<?php

namespace App\Controller;

use App\Form\CategorieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdminController extends AbstractController
{
  
   
    #[Route('/admin', name: 'admin', methods: ['GET'])]
public function index(Request $request, EntityManagerInterface $entityManager): Response
{
    return $this->render('Back.html.twig');
}

#[Route('/accueil', name: 'accueil', methods: ['GET'])]
public function accueil(Request $request, EntityManagerInterface $entityManager): Response
{
    return $this->render('news/band.html.twig');
}

}