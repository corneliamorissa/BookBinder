<?php

namespace App\Controller;

//use App\Service\AuthenticationService;
use App\Entity\MeetUp;
use App\Repository\MeetUpRepository;
use ContainerS8MXE1z\getMeetUpRepositoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/MeetUp", name="MeetUp")
 */
class MeetUpController extends AbstractController
{

    private array $stylesheets;
    private MeetUpRepository $MeetUpRepository;
    private array $AllMeetUpsArray;
    private array $AllSentMeetUpsArray;
    private array $AllReceivedMeetUpsArray;
    private array $AllOpenMeetUpsArray;
    private array $AllAcceptedMeetUpsArray;

    // check chatgpt for how to implement controller-> 1 function that provides all the arrays

    public function __construct(MeetUpRepository $meetUpRepository) {
        $this->stylesheets[] = 'main.css';
        $this->MeetUpRepository = $meetUpRepository;
    }
    #[Route("/MeetUp", name: "MeetUp")]
    public function getAllInvitesOfUser($userID): Response {
        $this->AllMeetUpsArray = $this->MeetUpRepository->findBy(['id_user_inviter' => $userID] || ['id_user_invited' => $userID]);
        return $this->AllMeetUpsArray;
    }

    public function getAllSentInvitesOfUser($userID){
        $this->AllSentMeetUpsArray = $this->MeetUpRepository->findBy(['id_user_inviter' => $userID]);
        return $this->AllSentMeetUpsArray;
    }

    public function getAllReceivedInvitesOfUser($userID): Response {
        $this->AllReceivedMeetUpsArray = $this->MeetUpRepository->findBy(['id_user_invited' => $userID]);
        return $this->AllReceivedMeetUpsArray;
    }
    public function getOpenInvitesForUser($userID): Response {
        $this->AllOpenMeetUpsArray = $this->MeetUpRepository->findBy(['id_user_inviter' => $userID] && ['accepted' => 0] && ['declined' => 0]);
        return $this->AllOpenMeetUpsArray;
    }
    public function getAcceptedInvitesForUser($userID): Response {
        $this->AllAcceptedMeetUpsArray = $this->MeetUpRepository->findBy(['id_user_inviter' => $userID] && ['accepted' => 0] && ['declined' => 0]);
        return $this->AllAcceptedMeetUpsArray;
    }
}