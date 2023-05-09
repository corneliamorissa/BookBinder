<?php

namespace App\Entity;

use PhpParser\Node\Scalar\String_;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository :: class)]
#[ORM\Table("user")]
class User
{
    #[ORM\UserID]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer", nullable: false)]
    private ?int $id = null;
    #[ORM\Column(type: "varchar",length: 50, nullable: false)]
    private ?string $Username = null;
    #[ORM\Column(type: "varchar",length: 50, nullable: false)]
    private ?string $First_name = null;
    #[ORM\Column(type: "varchar",length: 50, nullable: false)]
    private ?string $Last_name = null;
    #[ORM\Column(type: "varchar",length: 100, nullable: false)]
    private ?string $Street = null;
    #[ORM\Column(type: "integer", nullable: false)]
    private ?int $House_numer = null;
    #[ORM\Column(type: "integer", nullable: false)]
    private ?int $Postcode = null;
    #[ORM\Column(type: "date", nullable: false)]
    private ?string $BirthDate = null;
    #[ORM\Column(type: "integer", nullable: false)]
    private ?int $Private_account = null;
    #[ORM\Column(type: "integer", nullable: false)]
    private ?int $AvatarId = null;

    /**
     * @param string $Username
     * @param string $First_name
     * @param string $Last_name
     * @param string $Street
     * @param int $House_numer
     * @param int $Postcode
     * @param string $BirthDate
     * @param int $Private_account
     * @param int $AvatarId
     */
    public function __construct(string $Username, string $First_name, string $Last_name, string $Street, int $House_numer, int $Postcode, string $BirthDate, int $Private_account, int $AvatarId)
    {
        $this->Username = $Username;
        $this->First_name = $First_name;
        $this->Last_name = $Last_name;
        $this->Street = $Street;
        $this->House_numer = $House_numer;
        $this->Postcode = $Postcode;
        $this->BirthDate = $BirthDate;
        $this->Private_account = $Private_account;
        $this->AvatarId = $AvatarId;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->Username;
    }

    /**
     * @param string $Username
     */
    public function setUsername(string $Username): void
    {
        $this->Username = $Username;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->First_name;
    }

    /**
     * @param string $First_name
     */
    public function setFirstName(string $First_name): void
    {
        $this->First_name = $First_name;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->Last_name;
    }

    /**
     * @param string $Last_name
     */
    public function setLastName(string $Last_name): void
    {
        $this->Last_name = $Last_name;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->Street;
    }

    /**
     * @param string $Street
     */
    public function setStreet(string $Street): void
    {
        $this->Street = $Street;
    }

    /**
     * @return int
     */
    public function getHouseNumer(): int
    {
        return $this->House_numer;
    }

    /**
     * @param int $House_numer
     */
    public function setHouseNumer(int $House_numer): void
    {
        $this->House_numer = $House_numer;
    }

    /**
     * @return int
     */
    public function getPostcode(): int
    {
        return $this->Postcode;
    }

    /**
     * @param int $Postcode
     */
    public function setPostcode(int $Postcode): void
    {
        $this->Postcode = $Postcode;
    }

    /**
     * @return string
     */
    public function getBirthDate(): string
    {
        return $this->BirthDate;
    }

    /**
     * @param string $BirthDate
     */
    public function setBirthDate(string $BirthDate): void
    {
        $this->BirthDate = $BirthDate;
    }

    /**
     * @return int
     */
    public function getPrivateAccount(): int
    {
        return $this->Private_account;
    }

    /**
     * @param int $Private_account
     */
    public function setPrivateAccount(int $Private_account): void
    {
        $this->Private_account = $Private_account;
    }

    /**
     * @return int
     */
    public function getAvatarId(): int
    {
        return $this->AvatarId;
    }

    /**
     * @param int $AvatarId
     */
    public function setAvatarId(int $AvatarId): void
    {
        $this->AvatarId = $AvatarId;
    }

    public function getUsernameByID(string $ID) : ?User {
        $db = Db::getConnection();
        $stm = $db->prepare('SELECT Username FROM user WHERE UserID = :ID;');
        $stm->execute([':ID' => $ID]);

        $item = $stm->fetch();
        $username = $item['Username'];

        return $username;
    }


}