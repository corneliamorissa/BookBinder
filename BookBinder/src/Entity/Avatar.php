<?php

namespace App\Entity;

use App\Repository\AvatarRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvatarRepository :: class)]
#[ORM\Table("avatar")]
class Avatar
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer", nullable: false)]
    private ?int $id;

    #[ORM\Column(type: "blob", nullable: false)]
    private $image;

    #[ORM\OneToMany(mappedBy: 'avatar', targetEntity: User::class)]
    private Collection $users;

    public function __construct()
    {
        $this->roles = array('ROLE_USER');
    }

    /**
     * @return Collection
     */
    public function getUsers() : Collection
    {
        return $this->users;
    }

    /**
     * @param Collection $users
     * @return Avatar
     */
    public function setUsers(Collection $users): Avatar
    {
        $this->users = $users;
        return $this;
    }

    public string $dataUri;

    private $rawPhoto;

    /**
     * @return string
     */
    public function getDataUri(): string
    {
        return $this->dataUri;
    }

    /**
     * @param string $dataUri
     */
    public function setDataUri(string $dataUri): void
    {
        $this->dataUri = $dataUri;
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
     * @return Avatar
     */
    public function setId(?int $id): Avatar
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param ?string $Image
     */
    public function setImage($Image): void
    {
        $this->image = $Image;
    }

    public function setAvatar(User $user) : Avatar
    {
        $this->users = $user;
        return $this;
    }


    /**
     * @return string
     */
    public function __toString(): string
    {
        // Return a string representation of the Avatar
        // For example, you could return the avatar's name or any other relevant property
        return $this->id;
    }
}
