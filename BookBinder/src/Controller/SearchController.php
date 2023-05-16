<?php

namespace App\Controller;

use App\Service\AuthenticationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchControllerextends extends AbstractController
{

    private array $stylesheets;

    public function __construct(AuthenticationService $userService)
    {
        $this->stylesheets[] = 'main.css';

    }

    /**
     * @Route("/Search", name="Search")
     */


    #[Route("/Search", name: "Search")]
    public function search(): Response{


    }





}
