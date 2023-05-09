<?php

namespace App\Service;

use App\Entity\LoginUser;
use App\Repository\LoginUserRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class AuthenticationService
{
    private LoginUserRepository $loginUserRepository;
    private UserRepository $userRepository;

    public function __construct(LoginUserRepository $loginUserRepository, UserRepository $userRepository) {
        $this->userRepository = $userRepository;
        $this->loginUserRepository = $loginUserRepository;
    }

    public function authenticate(string $username, string $password): bool {
        $user = $this->userRepository->findOneBy(['Username', $username]);
        if (!$user) {
            return false; // User not found
        }
        $user_id = $user->getId();
        $user_pass = $this->loginUserRepository->findOneBy(['UserID', $user_id]);
        if (!password_verify($password, $user_pass->getPassword())) {
            return false; // Incorrect password
        }
        return true; // Authentication successful
    }
}