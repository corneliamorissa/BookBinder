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

    #[ORM\Column(type: "blob",length: 16777215, nullable: false)]
    private $image;

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
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): Avatar
    {
        $this->id = $id;
        return $this;
    }

    public function displayAvatar()
    {
        if(null === $this->rawPhoto) {
            $this->rawPhoto = "data:image/png;base64," . base64_encode(stream_get_contents($this->getImage()));
        }

        return $this->rawPhoto;
    }


    public function __construct() {
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
        $this->user = $user;
        return $this;
    }

}
