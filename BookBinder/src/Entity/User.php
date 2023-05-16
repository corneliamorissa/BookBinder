<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository :: class)]
#[ORM\Table("user")]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer", nullable: false)]
    private ?int $id = null;
    #[ORM\Column(type: "string",length: 50, nullable: false)]
    private ?string $username = null;
    #[ORM\Column(type: "string",length: 50, nullable: false)]
    private ?string $first_name = null;
    #[ORM\Column(type: "string",length: 50, nullable: false)]
    private ?string $last_name = null;
    #[ORM\Column(type: "string",length: 100, nullable: false)]
    private ?string $street = null;
    #[ORM\Column(type: "integer", nullable: false)]
    private ?int $house_number = null;
    #[ORM\Column(type: "integer", nullable: false)]
    private ?int $postcode = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: false)]
    private ?\DateTime $birthdate = null;
    #[ORM\Column(type: "integer", nullable: false)]
    private ?int $private_account = null;
    #[ManyToOne(targetEntity: Avatar::class)]
    #[JoinColumn(name: 'avatar_id', referencedColumnName: 'id')]
    #[ORM\Column(type: "integer", nullable: false)]
    private ?int $avatar_id = null;

    #[ORM\Column(type: 'json')]
    private $roles = [];


    #[ORM\Column(type: "string", length: 256, nullable: false)]
    private ?string $password;

    #[OneToMany(targetEntity: UserBook::class, mappedby:"userid")]
    private $userbooks;
    #[OneToMany(targetEntity: MeetUp::class, mappedby:"id_user_inviter")]
    private $inviting_user;
    #[OneToMany(targetEntity: Meetup::class, mappedby:"id_user_invited")]
    private $invited_user;



    public function __construct()
    {
        $this->roles = array('ROLE_USER');
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
    public function setId(?int $UserID): User
    {
        $this->id = $UserID;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     */
    public function setFirstName(string $first_name): void
    {
        $this->first_name = $first_name;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     */
    public function setLastName(string $last_name): void
    {
        $this->last_name = $last_name;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    /**
     * @return int
     */
    public function getHouseNumber(): int
    {
        return $this->house_number;
    }

    /**
     * @param int $house_number
     */
    public function setHouseNumber(int $house_number): void
    {
        $this->house_number = $house_number;
    }

    /**
     * @return int
     */
    public function getPostcode(): int
    {
        return $this->postcode;
    }

    /**
     * @param int $postcode
     */
    public function setPostcode(int $postcode): void
    {
        $this->postcode = $postcode;
    }

    /**
     * @return \DateTime
     */
    public function getBirthdate(): \DateTime
    {
        return $this->birthdate;
    }

    /**
     * @param string $birthdate
     */
    public function setBirthdate(\DateTime $birthdate): void
    {
        $this->birthdate = $birthdate;
    }

    /**
     * @return int
     */
    public function getPrivateAccount(): int
    {
        return $this->private_account;
    }

    /**
     * @param int $private_account
     */
    public function setPrivateAccount(int $private_account): void
    {
        $this->private_account = $private_account;
    }

    /**
     * @return int
     */
    public function getAvatarId(): int
    {
        return $this->avatar_id;
    }

    /*
     * @param int $AvatarId
     */
    public function setAvatarId(int $avatar_id): void
    {
        $this->avatar_id = $avatar_id;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }


    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Returning a salt is only needed if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * The public representation of the user (e.g. a username, an email address, etc.)
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {

        return (string) $this->username;
    }
}