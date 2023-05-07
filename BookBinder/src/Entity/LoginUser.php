<?php

namespace App\Entity;

class LoginUser
{
    #[ORM\PasswordID]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer", nullable: false)]
    private ?int $id = null;
    #[ORM\Column(type: "integer", nullable: false)]
    private int $userId;
    #[ORM\Column(type: "varchar",length: 100, nullable: false)]
    private string $password;
    public function __construct(string $username, string $password) {
        $this->username = $username;
        $this->password = $password;
    }



    /**
     * @return int fase in which the course is given
     */
    public function getPassword(): int {
        return $this->password;
    }

    /**
     * @param int $fase fase in which the course is given
     * @return Course current course object
     */
    public function setPassword(int $password): LoginUser {
        $this->password = $password;
        return $this;
    }

    public function getIDByPassword(string $password) : ?LoginUser {
        $db = Db::getConnection();
        $stm = $db->prepare('SELECT UserID FROM user_password WHERE Password = :password;');
        $stm->execute([':password' => $password]);

        $item = $stm->fetch();
        $ID = $item['UserID'];

        return $ID;
    }

    /*
    public function getUsernameByID(string $ID) : ?LoginUser {
        $db = Db::getConnection();
        $stm = $db->prepare('SELECT Username FROM user WHERE UserID = :ID;');
        $stm->execute([':ID' => $ID]);

        $item = $stm->fetch();
        $username = $item['Username'];

        return $username;
    }
    */



}