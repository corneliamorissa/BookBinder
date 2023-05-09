<?php

namespace App\Entity;

use App\Repository\BooksRepository;
use Doctrine\ORM\Mapping as ORM;
#[ORM\Entity(repositoryClass: BooksRepository :: class)]
#[ORM\Table("books")]
class Books
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer", nullable: false)]
    private int $id ;

    #[ORM\Column(type: "varchar",length: 45, nullable: false)]
    private string $title;
    #[ORM\Column(type: "integer", nullable: false)]
    private int $numberOfPages ;

    #[ORM\Column(type: "varchar",length: 45, nullable: false)]
    private string $author ;
    #[ORM\Column(type: "varchar",length: 45, nullable: false)]
    private string $isbn ;
    #[ORM\Column(type: "integer", nullable: false)]
    private int $numberOfFollowers ;

    #[ManyToOne(targetEntity: Library::class, inversedby:"books")]
    #[JoinColumn(name: 'libraryID', referencedColumnName: 'id')]
    #[ORM\Column(type: "integer", nullable: false)]
    private int $library ;
    #[ORM\Column(type:"decimal",precision : 3,scale : 1)]
    private float $rating ;
    #[ORM\Column(type: "integer", nullable: false)]
    private int $numberOfVotes ;

    #[OneToMany(targetEntity: UserBook::class, mappedby:"bookid")]
    private $userbooks;
    public function __construct(string $title,int $numberOfPages,string $author, string $ISBN, int $numberOfFollowers,
                                int $libraryID, float $rating, int $numberOfVotes ) {
        $this->title = $title;
        $this->numberOfPages = $numberOfPages;
        $this->author = $author;
        $this->ISBN = $ISBN;
        $this->numberOfFollowers = $numberOfFollowers;
        $this->library = $libraryID;
        $this->rating = $rating;
        $this->numberOfVotes = $numberOfVotes;

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
    public function getNumberOfPages(): int
    {
        return $this->numberOfPages;
    }

    /**
     * @param int $numberOfPages
     */
    public function setNumberOfPages(int $numberOfPages): void
    {
        $this->numberOfPages = $numberOfPages;
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
        return $this->ISBN;
    }

    /**
     * @param string $ISBN
     */
    public function setISBN(string $ISBN): void
    {
        $this->ISBN = $ISBN;
    }

    /**
     * @return int
     */
    public function getNumberOfFollowers(): int
    {
        return $this->numberOfFollowers;
    }

    /**
     * @param int $numberOfFollowers
     */
    public function setNumberOfFollowers(int $numberOfFollowers): void
    {
        $this->numberOfFollowers = $numberOfFollowers;
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
    public function getNumberOfVotes(): int
    {
        return $this->numberOfVotes;
    }

    /**
     * @param int $numberOfVotes
     */
    public function setNumberOfVotes(int $numberOfVotes): void
    {
        $this->numberOfVotes = $numberOfVotes;
    }


    public function getTitleByID(int $ID) : ?Books {
        $db = Db::getConnection();
        $stm = $db->prepare('SELECT Title FROM books WHERE BookID = :ID;');
        $stm->execute([':ID' => $ID]);

        $item = $stm->fetch();
        $title = $item['Title'];

        return $title;
    }



}