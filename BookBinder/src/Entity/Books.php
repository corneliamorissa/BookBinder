<?php

namespace App\Entity;

use App\Repository\BooksRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;

#[ORM\Entity(repositoryClass: BooksRepository :: class)]
#[ORM\Table("books")]
class Books
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer", nullable: false)]
    private int $id ;

    #[ORM\Column(type: "string", nullable: false)]
    private string $title;
    #[ORM\Column(type: "integer", nullable: false)]
    private int $number_of_pages ;

    #[ORM\Column(type: "string", nullable: false)]
    private string $author ;
    #[ORM\Column(type: "string", nullable: false)]
    private string $isbn ;
    #[ORM\Column(type: "integer", nullable: false)]
    private int $number_of_followers ;

    #[ManyToOne(targetEntity: Library::class, inversedBy:"books")]
    #[JoinColumn(name: 'library', referencedColumnName: 'id')]
    #[ORM\Column(type: "integer", nullable: false)]
    private int $library;
    #[ORM\Column(type:"decimal",precision : 3,scale : 1)]
    private float $rating ;
    #[ORM\Column(type: "integer", nullable: false)]
    private int $number_of_votes ;

    #[OneToMany(mappedBy: "book", targetEntity: UserBook::class)]
    private Collection $userbooks;

    public function __construct()
    {
        $this->userbooks = new ArrayCollection();
    }


    public function setId(int $id):void
    {
        $this ->id = $id;
    }
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getNumberOfpages(): int
    {
        return $this->number_of_pages;
    }

    /**
     * @param int $number_of_pages
     */
    public function setNumberOfpages(int $number_of_pages): void
    {
        $this->number_of_pages = $number_of_pages;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getISBN(): string
    {
        return $this->isbn;
    }

    /**
     * @param string $ISBN
     */
    public function setISBN(string $ISBN): void
    {
        $this->isbn = $ISBN;
    }

    /**
     * @return int
     */
    public function getNumberOffollowers(): int
    {
        return $this->number_of_followers;
    }

    /**
     * @param int $number_of_followers
     */
    public function setNumberOffollowers(int $number_of_followers): void
    {
        $this->number_of_followers = $number_of_followers;
    }

    /**
     * @return int
     */
    public function getLibrary(): int
    {
        return $this->library;
    }

    /**
     * @param int $library
     */
    public function setLibrary(int $library): void
    {
        $this->library = $library;
    }

    /**
     * @return float
     */
    public function getRating(): float
    {
        return $this->rating;
    }

    /**
     * @param float $rating
     */
    public function setRating(float $rating): void
    {
        $this->rating = $rating;
    }

    /**
     * @return int
     */
    public function getNumberOfvotes(): int
    {
        return $this->number_of_votes;
    }

    /**
     * @param int $number_of_votes
     */
    public function setNumberOfvotes(int $number_of_votes): void
    {
        $this->number_of_votes = $number_of_votes;
    }





}
