<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LivreController extends AbstractController
{
    #[Route('/livre', name: 'app_livre')]
    public function index(BookRepository $bookRepository): Response
    {   
        $books= $bookRepository->findAll();
        return $this->render('livre/index.html.twig', [
            'controller_name' => 'Affichage de tout les Livres',
            'books'=> $books,
        ]);
    }

    #[Route('/livre/{id}', name: 'bookId')]
    public function personID(BookRepository $bookRepository,$id): Response
    {
        $books= $bookRepository->findOneBy(array('id'=>$id));
       //var_dump($persons,$id);

        return $this->render('livre/infoLivre.html.twig', [
            'controller_name' => 'HomeController',
            'bookById' => $books,
        ]);
    }


    
    #[Route('/ajoutlivre', name: 'livre',methods: ['GET','POST']) ]
    public function ajoutPerso(EntityManagerInterface $entityManager,Request $request): Response
    {
        
        
        $book=new Book();        
        $form= $this->createForm(BookType::class, $book);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('app_livre');
        }
        return $this->render('livre/creerLivre.html.twig', [
            'controller_name' => 'Creation Livre',
            'form' => $form->createView(),
        ]);
    }


}
