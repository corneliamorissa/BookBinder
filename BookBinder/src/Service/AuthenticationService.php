<?php

namespace App\Service;

use App\Repository\UserRepository;

class AuthenticationService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function authenticate(string $username, string $password): bool {
        $user = $this->userRepository->findByUsername($username);
        if (!$user) {
            return false; // User not found
        }
        if (!password_verify($password, $user->getPassword())) {
            return false; // Incorrect password
        }
        return true; // Authentication successful
    }
}