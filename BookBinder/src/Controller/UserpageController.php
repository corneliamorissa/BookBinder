<?php

namespace App\Controller;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class UserpageController extends AbstractController
{

    //#[Route('/User', name: 'UserPage', methods: ['GET'])]
    //public function user(){

   // }
    private UserRepository $userRepository;
    public function __construct(UserRepository $userRepository) {
        $this->stylesheets[] = 'main.css';
        $this -> userRepository = $userRepository;

    }
}