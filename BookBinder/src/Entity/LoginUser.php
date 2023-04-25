<?php

namespace App\Entity;

class LoginUser
{
    private string $username;
    private string $password;
    public function __construct(string $username, string $password) {
        $this->username = $username;
        $this->password = $password;
    }

    public function getUsername(): ?string {
        return $this->username;
    }

    /**
     * @param string|null $id unique id from the database
     * @return Course current course object
     */
    protected function setUsername(?string $username): LoginUser {
        $this->username = $username;
        return $this;
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

    static function getIDByPassword(string $password) : ?LoginUser {
        $db = Db::getConnection();
        $stm = $db->prepare('SELECT UserID FROM user_password WHERE Password = :password;');
        $stm->execute([':password' => $password]);

        $item = $stm->fetch();
        $ID = $item['UserID'];

        return $ID;
    }

    static function getUsernameByID(string $ID) : ?LoginUser {
        $db = Db::getConnection();
        $stm = $db->prepare('SELECT Username FROM user WHERE UserID = :ID;');
        $stm->execute([':ID' => $ID]);

        $item = $stm->fetch();
        $username = $item['Username'];

        return $username;
    }



}