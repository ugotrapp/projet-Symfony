<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */

class HomePageController extends AbstractController
{
    /**
     * @Route("/", name="home_index", methods={"GET","POST"})
     */
    public function index(BookRepository $bookRepository,Request $request): Response
    {   
        // dump($request->request->all());
        // exit();
        return $this->render('book/index.html.twig', [
            'books' => $bookRepository->findAll(),
        ]);
    }
}
