<?php

namespace App\Entity;
use App\Repository\MeetUpRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Type;

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
    private DateTime $date_time;
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
     * @param DateTime $date_time
     * @param int $accepted
     * @param int $declined
     * @param int $id_library
     */
    public function __construct(int $id_user_inviter, int $id_user_invited, DateTime $date_time, int $accepted, int $declined, int $id_library)
    {
        $this->roles = array('ROLE_USER');

        $this->id_user_inviter = $id_user_inviter;
        $this->id_user_invited = $id_user_invited;
        $this->date_time = $date_time;
        $this->accepted = $accepted;
        $this->declined = $declined;
        $this->id_library = $id_library;

    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
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
     * @return DateTime
     */
    public function getDateTime(): DateTime
    {
        return $this->date_time;
    }

    /**
     * @param DateTime $date_time
     */
    public function setDateTime(DateTime $date_time): void
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