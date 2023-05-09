<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

class MeetUp
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer", nullable: false)]
    private ?int $id = null;
    #[ORM\Column(type: "integer", nullable: false)]
    private int $id_user_inviter;
    #[ORM\Column(type: "integer", nullable: false)]
    private int $id_user_invited;
    #[ORM\Column(type: "datetime")]
    private string $date_time;
    #[ORM\Column(type: "integer", nullable: false)]
    private int $accepted;
    #[ORM\Column(type: "integer", nullable: false)]
    private int $declined;

    /**
     * @param int $id_user_inviter
     * @param int $id_user_invited
     * @param string $date_time
     * @param int $accepted
     * @param int $declined
     */
    public function __construct(int $id_user_inviter, int $id_user_invited, string $date_time, int $accepted, int $declined)
    {
        $this->id_user_inviter = $id_user_inviter;
        $this->id_user_invited = $id_user_invited;
        $this->date_time = $date_time;
        $this->accepted = $accepted;
        $this->declined = $declined;
    }

    /**
     * @return int
     */
    public function getIdUserInviter(): int
    {
        return $this->id_user_inviter;
    }

    /**
     * @param int $id_user_inviter
     */
    public function setIdUserInviter(int $id_user_inviter): void
    {
        $this->id_user_inviter = $id_user_inviter;
    }

    /**
     * @return int
     */
    public function getIdUserInvited(): int
    {
        return $this->id_user_invited;
    }

    /**
     * @param int $id_user_invited
     */
    public function setIdUserInvited(int $id_user_invited): void
    {
        $this->id_user_invited = $id_user_invited;
    }

    /**
     * @return string
     */
    public function getDateTime(): string
    {
        return $this->date_time;
    }

    /**
     * @param string $date_time
     */
    public function setDateTime(string $date_time): void
    {
        $this->date_time = $date_time;
    }

    /**
     * @return int
     */
    public function getAccepted(): int
    {
        return $this->accepted;
    }

    /**
     * @param int $accepted
     */
    public function setAccepted(int $accepted): void
    {
        $this->accepted = $accepted;
    }

    /**
     * @return int
     */
    public function getDeclined(): int
    {
        return $this->declined;
    }

    /**
     * @param int $declined
     */
    public function setDeclined(int $declined): void
    {
        $this->declined = $declined;
    }


}