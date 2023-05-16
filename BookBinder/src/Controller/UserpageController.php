<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class UserpageController
{

    #[Route('/User', name: 'UserPage', methods: ['GET'])]
    public function user(){

    }
}