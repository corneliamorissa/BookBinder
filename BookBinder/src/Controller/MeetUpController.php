<?php

namespace App\Controller;

//use App\Service\AuthenticationService;
use App\Entity\MeetUp;
use App\Repository\MeetUpRepository;
use ContainerS8MXE1z\getMeetUpRepositoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/**
 * @Route("/MeetUp", name="MeetUp")
 */
class MeetUpController extends AbstractController
{

    private array $stylesheets;
    private MeetUpRepository $MeetUpRepository;
    private array $meetUpArray;
    public function __construct(MeetUpRepository $meetUpRepository) {
        $this->stylesheets[] = 'main.css';
        $this->MeetUpRepository = $meetUpRepository;
    }

    public function getAllInvitesOfUser($userID): Response {
        $this->meetUpArray = $this->MeetUpRepository->findBy(['id_user_inviter' => $userID] || ['id_user_invited' => $userID]);
        return $this->meetUpArray;
    }

    public function getAllSentInvitesOfUser($userID): Response {
        $this->meetUpArray = $this->MeetUpRepository->findBy(['id_user_inviter' => $userID]);
        return $this->meetUpArray;
    }

    public function getAllReceivedInvitesOfUser($userID): Response {
        $this->meetUpArray = $this->MeetUpRepository->findBy(['id_user_invited' => $userID]);
        return $this->meetUpArray;
    }
    public function getOpenInvitesForUser($userID): Response {
        $this->meetUpArray = $this->MeetUpRepository->findBy(['id_user_inviter' => $userID] && ['accepted' => 0] && ['declined' => 0]);
        return $this->meetUpArray;
    }
    public function getAcceptedInvitesForUser($userID): Response {
        $this->meetUpArray = $this->MeetUpRepository->findBy(['id_user_inviter' => $userID] && ['accepted' => 0] && ['declined' => 0]);
        return $this->meetUpArray;
    }
}