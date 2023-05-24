<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{

    /*private array $stylesheets;

    public function __construct(AuthenticationService $userService)
    {
        $this->stylesheets[] = 'main.css';

    }*/

    /*#[Route("/Search", name: "Search")]
    public function searchByISBN(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $isbn = $request->get('isbn');

        $entityManager = $this->getDoctrine()->getManager();
        $bookRepository = $entityManager->getRepository(Books::class);

        $book = $bookRepository->findOneBy(['isbn' => $isbn]);

        if (!$book) {
            throw $this->createNotFoundException('Book not found');
        }

        return $this->render('search.html.twig', [
            'book' => $book,
        ]);
    }*/



}
