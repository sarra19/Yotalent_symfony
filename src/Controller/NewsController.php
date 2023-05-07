<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class NewsController extends AbstractController
{
  
   
    #[Route('/news', name: 'news', methods: ['GET'])]
public function index(Request $request, EntityManagerInterface $entityManager): Response
{
    return $this->render('news/news.html.twig');
}

#[Route('/band', name: 'band', methods: ['GET'])]
public function band(Request $request, EntityManagerInterface $entityManager): Response
{
    return $this->render('news/band.html.twig');
}

#[Route('/detail', name: 'app_new', methods: ['GET'])]
public function detail(Request $request, EntityManagerInterface $entityManager): Response
{
    return $this->render('news/blog-details.html.twig');
}

}