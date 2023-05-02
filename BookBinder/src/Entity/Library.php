<?php

namespace App\Entity;

class Library
{
    private ?int $id = null;
    private string $name;
    private string $street;
    private int $housenumber;

    private int $postcode;


    /**
     * @param string $name
     * @param string $street
     * @param int $housenumber
     * @param int $postcode
     */
    public function __construct(string $name, string $street, int $housenumber, int $postcode)
    {
        $this->name = $name;
        $this->street = $street;
        $this->housenumber = $housenumber;
        $this->postcode = $postcode;
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    /**
     * @return int
     */
    public function getHousenumber(): int
    {
        return $this->housenumber;
    }

    /**
     * @param int $housenumber
     */
    public function setHousenumber(int $housenumber): void
    {
        $this->housenumber = $housenumber;
    }

    /**
     * @return int
     */
    public function getPostcode(): int
    {
        return $this->postcode;
    }

    /**
     * @param int $postcode
     */
    public function setPostcode(int $postcode): void
    {
        $this->postcode = $postcode;
    }

    //Not tested yet
    static function getLibraryByID(int $ID) : ?Library {
        $db = Db::getConnection();
        $stm = $db->prepare('SELECT LibraryID, Name,Street, Housenumber, Postcode FROM libraries WHERE LibraryID = :ID;');
        $stm->execute([':ID' => $ID]);

        $library = null;
        while($item = $stm->fetch()) {
            $library = new Library($item['Name'],$item['Street'],$item['Housenumber'],$item['Postcode']);
            $library -> setId($item['LibraryID']);
        }

        return $library;
    }


}