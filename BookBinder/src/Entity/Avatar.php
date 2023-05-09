<?php

namespace App\Entity;

class Avatar
{
    #[ORM\AvatarID]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer", nullable: false)]
    private ?int $id = null;
    #[ORM\Column(type: "blob",length: 16777215, nullable: false)]
    private string $Image;


        public function __construct(string $Image) {
            $this->Image = $Image;
        }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->Image;
    }

    /**
     * @param string $Image
     */
    public function setImage(string $Image): void
    {
        $this->Image = $Image;
    }

    public function getImageByID(string $ID) : ?Avatar {
        $db = Db::getConnection();
        $stm = $db->prepare('SELECT Image FROM Avatar WHERE AvatarId = :ID;');
        $stm->execute([':ID' => $ID]);

        $item = $stm->fetch();
        $image = $item['Image'];

        return $image;
    }

}