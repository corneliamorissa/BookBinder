<?php

namespace App\Entity;

use App\Repository\LoginUserRepository;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: LoginUserRepository :: class)]
#[ORM\Table("user_password")]
class LoginUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer", nullable: false)]
    private ?int $id = null;


    #[ORM\OneToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private ?User $user;

    #[ORM\Column(type: "integer", nullable: false)]
    private ?int $user_id = null;

    #[ORM\Column(type: "string", length: 100)]
    private ?string $password;
    public function __construct(?string $password) {
        $this->password = $password;
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
    public function setId(?int $id): LoginUser
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    /**
     * @param int|null $id
     */
    public function setUserId(?int $id): LoginUser
    {
        $this->user_id = $id;
        return $this;
    }

    public function getUser(): User {
        return $this->user;
    }

    protected function setUser(User $user): LoginUser {
        $this->user = $user;
        return $this;
    }

    public function getPassword(): string {
        return $this->password;
    }


    public function setPassword(string $password): LoginUser {
        $this->password = $password;
        return $this;
    }




}