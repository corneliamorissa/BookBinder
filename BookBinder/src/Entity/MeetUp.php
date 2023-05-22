<?php

namespace App\Entity;
use App\Repository\LoginUserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MeetUpRepository :: class)]
#[ORM\Table("meetup")]
class MeetUp
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer", nullable: false)]
    private ?int $id = null;
    #[ManyToOne(targetEntity: User::class)]
    #[JoinColumn(name: 'id_user_inviter', referencedColumnName: 'id')]
    #[ORM\Column(type: "integer", nullable: false)]
    private int $id_user_inviter;
    #[ManyToOne(targetEntity: User::class)]
    #[JoinColumn(name: 'id_user_invited', referencedColumnName: 'id')]
    #[ORM\Column(type: "integer", nullable: false)]
    private int $id_user_invited;
    #[ORM\Column(type: "datetime")]
    private string $date_time;
    #[ORM\Column(type: "integer", nullable: true)]
    private int $accepted;
    #[ORM\Column(type: "integer", nullable: true)]
    private int $declined;

    #[ManyToOne(targetEntity: Library::class)]
    #[JoinColumn(name: 'id_library', referencedColumnName: 'id')]
    #[ORM\Column(type: "integer", nullable: false)]
    private int $id_library;

    /**
     * @param int $id_user_inviter
     * @param int $id_user_invited
     * @param string $date_time
     * @param int $accepted
     * @param int $declined
     * @param int $id_library
     */
    public function __construct(int $id_user_inviter, int $id_user_invited, string $date_time, int $accepted, int $declined, int $id_library)
    {
        $this->id_user_inviter = $id_user_inviter;
        $this->id_user_invited = $id_user_invited;
        $this->date_time = $date_time;
        $this->accepted = $accepted;
        $this->declined = $declined;
        $this->id_library = $id_library;
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

    /**
     * @return int
     */
    public function getIdLibrary(): int
    {
        return $this->id_library;
    }

    /**
     * @param int $id_library
     */
    public function setIdLibrary(int $id_library): void
    {
        $this->id_library = $id_library;
    }


}