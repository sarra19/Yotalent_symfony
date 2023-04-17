<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\Evenement1Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Planning;
use App\Repository\EvenementRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use App\Entity\PdfGeneratorService;
use Knp\Component\Pager\PaginatorInterface;


#[Route('/evenement')]
class EvenementController extends AbstractController
{

    #[Route('/show_in_map/{idev}', name: 'app_evenement_map', methods: ['GET'])]
    public function Map( Evenement $idev,EntityManagerInterface $entityManager ): Response
    {

        $idev = $entityManager
            ->getRepository(Evenement::class)->findBy( 
                ['idev'=>$idev ]
            );
        return $this->render('evenement/api_arcgis.html.twig', [
            'evenements' => $idev,
        ]);
    }

    #[Route('/', name: 'app_evenement_index', methods: ['GET'])]
    public function index(Request $request, EntityManagerInterface $entityManager ): Response
    {

        $queryBuilder = $entityManager->createQueryBuilder()
            ->select('e')
            ->from(Evenement::class, 'e');

        // Basic search by username or nbvotes
        $searchQuery = $request->query->get('search');
        if ($searchQuery) {
            $queryBuilder->andWhere($queryBuilder->expr()->orX(
                $queryBuilder->expr()->like('e.nomev', ':searchQuery'),
                $queryBuilder->expr()->eq('e.datedev', ':searchQuery'),
                $queryBuilder->expr()->eq('e.localisation', ':searchQuery'),
                $queryBuilder->expr()->eq('e.idev', ':searchQuery'),

            ))
            ->setParameter('searchQuery', $searchQuery);
        }

        // Sorting
        $sort = $request->query->get('sort');
        if ($sort) {
            $queryBuilder->orderBy('e.' . $sort, 'ASC');
        }

        $evenements = $queryBuilder->getQuery()->getResult();

        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenements,
        ]);
       
    }

    #[Route('/front', name: 'app_evenement_indexfront', methods: ['GET'])]
    public function front(Request $request,EntityManagerInterface $entityManager,PaginatorInterface $paginator): Response
    {
        $evenements = $entityManager
        
            ->getRepository(Evenement::class)
            ->findAll();

            $evenements = $paginator->paginate(
                $evenements, /* query NOT result */
                $request->query->getInt('page', 1),
                6
            );

        return $this->render('evenement/indexFront.html.twig', [
            'evenements' => $evenements,
        ]);
    }
   
   

    #[Route('/new', name: 'app_evenement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, NotifierInterface $notifier): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(Evenement1Type::class, $evenement);
        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) {
            /////code image
            $file = $evenement->getImageev();
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('uploads'),$filename);
            $evenement->setImageev($filename);
            /////
          
            $entityManager->persist($evenement);
            $nomev = $form->get('nomev')->getData();
            $evenements = $entityManager
            ->getRepository(Evenement::class)
            ->findBy(['nomev'=>$nomev]);
            if (empty($evenements)) 
           {
            $entityManager->flush();
            $notifier->send(new Notification('Evenement avec ajouter succées ', ['browser']));

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }
        else{
            $notifier->send(new Notification('Evenement exist déja  ', ['browser']));
            return $this->redirectToRoute('app_evenement_new', [], Response::HTTP_SEE_OTHER);

        }
    }
        return $this->renderForm('evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }



    #[Route('/{idev}', name: 'app_evenement_show', methods: ['GET'])]
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    #[Route('/{idev}/edit', name: 'app_evenement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Evenement1Type::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                        /////code image
                        $file = $evenement->getImageev();
                        $filename = md5(uniqid()).'.'.$file->guessExtension();
                        $file->move($this->getParameter('uploads'),$filename);
                        $evenement->setImageev($filename);
                        /////
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{idev}', name: 'app_evenement_delete', methods: ['POST'])]
    public function delete(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getIdev(), $request->request->get('_token'))) {
            $entityManager->remove($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/pdf/evenement', name: 'generator_service')]
    public function pdfEvenement(): Response
    { 
        $evenement= $this->getDoctrine()
        ->getRepository(Evenement::class)
        ->findAll();

   

        $html =$this->renderView('pdf/index.html.twig', ['evenement' => $evenement]);
        $pdfGeneratorService=new PdfGeneratorService();
        $pdf = $pdfGeneratorService->generatePdf($html);

        return new Response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="document.pdf"',
        ]);
       
    }




}
