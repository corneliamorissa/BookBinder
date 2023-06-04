<?php

namespace App\Controller;
use App\Repository\UserRepository;
use PhpParser\Node\Expr\Throw_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class APIController extends AbstractController
{
    #[Route('/api/check_user', name: 'check_user', methods: ['POST'])]
    public function checkUser(Request $request, UserRepository $user_repository): Response {
        $username = $request->request->get('sign_up_form_username');
        if ($username == null) {
            return $this->json(['status' => 'error','msg' => 'no user given'], 400);
        }

        $user = $user_repository->findOneBy(['username'=>$username]);
        if ($user != null) {
            return $this->json(['status' => 'nok', 'msg' => 'user already exists'], 404);
        }

        return $this->json(['status' => 'ok','msg' => 'user already registered']);
    }
}
