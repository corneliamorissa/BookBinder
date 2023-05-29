<?php

namespace App\Entity;
use App\Repository\UserBookRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;


#[ORM\Entity(repositoryClass: UserBookRepository :: class)]
#[ORM\Table("user_book")]

class UserBook
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer", nullable: false)]
    private ?int $id;

    #[ManyToOne(targetEntity: Books::class)]
    #[JoinColumn(name: 'bookID', referencedColumnName: 'bookId')]
    #[ORM\Column(type: "integer", nullable: false)]
    private ?int $bookid = null;

    #[ManyToOne(targetEntity: User::class)]
    #[JoinColumn(name: 'userID', referencedColumnName: 'id')]
    #[ORM\Column(type: "integer", nullable: false)]
    private ?int $userid = null;

    #[ManyToOne(targetEntity: Books::class, inversedBy: "userbooks")]
    #[JoinColumn(name: 'bookID', referencedColumnName: 'bookId')]
    private ?Books $book = null;


    /**
     * @param int $bookid
     * @param int $userid
     */
    public function __construct()
    {

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
    public function getBookid(): int
    {
        return $this->bookid;
    }

    /**
     * @param int $bookid
     */
    public function setBookid(int $bookid): void
    {
        $this->bookid = $bookid;
    }

    /**
     * @return int
     */
    public function getUserid(): int
    {
        return $this->userid;
    }

    /**
     * @param int $userid
     */
    public function setUserid(int $userid): void
    {
        $this->userid = $userid;
    }


}