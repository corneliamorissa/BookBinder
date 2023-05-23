<?php

namespace App\Controller;
use App\Repository\UserRepository;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class UserpageController extends AbstractController
{
    private UserRepository $myUserRepository;
    private User $user;

    //#[Route('/User', name: 'UserPage', methods: ['GET'])]
    //public function user(){

   // }
    private UserRepository $userRepository;
    public function __construct(UserRepository $userRepository) {
        $this->stylesheets[] = 'main.css';
        $this -> userRepository = $userRepository;

    }

    public function findUserById($userId){
        $this -> user = $this -> myUserRepository -> find(["id"=> $userId]);
        return $this ->user;
    }
     //#[Route('/User/{id}', name: 'product_show')]

}
