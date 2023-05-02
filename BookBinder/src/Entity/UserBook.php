<?php

namespace App\Entity;
use App\Repository\UserBookRepository;
use Doctrine\ORM\Mapping\Entity;

#[ORM\Entity(repositoryClass: UserBookRepository :: class)]
#[ORM\Table("user_book")]

class UserBook
{
    private ?int $id = null;
    private int $bookid;
    private int $userid;

    /**
     * @param int $bookid
     * @param int $userid
     */
    public function __construct(int $bookid, int $userid)
    {
        $this->bookid = $bookid;
        $this->userid = $userid;
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

    //not tested yet
    static function getUserAndBookByID(int $ID) : ?UserBook {
        $db = Db::getConnection();
        $stm = $db->prepare('SELECT FollowID, UserID,BookID FROM user_book WHERE FollowID = :ID;');
        $stm->execute([':ID' => $ID]);

        $userAndBook = null;
        while($item = $stm->fetch()) {
            $userAndBook = new UserBook($item['BookID'],$item['UserID']);
            $userAndBook -> setId($item['ID']);
        }
        return $userAndBook;
    }


    //not tested yet
    static function getBooksByUserID(int $ID) : ?array{
        $db = Db::getConnection();
        $stm = $db->prepare('SELECT BookID FROM user_book WHERE UserID = :ID;');
        $stm->execute([':ID' => $ID]);

        $values = [];
        while ($row = $stm->fetch()) {
            $value = (int) $row['bookID'];
            $values[] = $value;
        }
        return $values;

    }
    static function getUsersByBookID(int $ID) : ?array{
        $db = Db::getConnection();
        $stm = $db->prepare('SELECT UserID FROM user_book WHERE BookID = :ID;');
        $stm->execute([':ID' => $ID]);

        $values = [];
        while ($row = $stm->fetch()) {
            $value = (int) $row['UserID'];
            $values[] = $value;
        }
        return $values;

    }


}