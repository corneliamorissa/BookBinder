<?php

namespace App\Entity;

class Books
{
    private string $title;
    private int $numberOfPages;
    private string $author;
    private string $ISBN;
    private int $numberOfFollowers;
    private int $libraryID;
    private float $rating;
    private int $numberOfVotes;
    public function __construct(string $title,int $numberOfPages,string $author, string $ISBN, int $numberOfFollowers,
                                int $libraryID, float $rating, int $numberOfVotes ) {
        $this->title = $title;
        $this->numberOfPages = $numberOfPages;
        $this->author = $author;
        $this->ISBN = $ISBN;
        $this->numberOfFollowers = $numberOfFollowers;
        $this->libraryID = $libraryID;
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
    public function getLibraryID(): int
    {
        return $this->libraryID;
    }

    /**
     * @param int $libraryID
     */
    public function setLibraryID(int $libraryID): void
    {
        $this->libraryID = $libraryID;
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