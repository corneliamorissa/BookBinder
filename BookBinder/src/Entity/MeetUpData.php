<?php

namespace App\Entity;

use DateTime;

class MeetUpData
{
    public string $nameInvited;
    private DateTime $dateTime;
    public string $library;

    public function __construct(string $nameInvited, DateTime $dateTime, string $library){
        $this->nameInvited = $nameInvited;
        $this->dateTime = $dateTime;
        $this->library = $library;
    }

    /**
     * @return string
     */
    public function getNameUserInvited(): string
    {
        return $this->nameInvited;
    }

    /**
     * @param string $nameInvited
     */
    public function setNameUserInvited(string $nameInvited): void
    {
        $this->nameInvited = $nameInvited;
    }

    /**
     * @return DateTime
     */
    public function getDateTime(): DateTime
    {
        return $this->dateTime;
    }

    /**
     * @param DateTime $dateTime
     */
    public function setDateTime(DateTime $dateTime): void
    {
        $this->dateTime = $dateTime;
    }

    /**
     * @return string
     */
    public function getNameLibrary(): string
    {
        return $this->library;
    }

    /**
     * @param string $library
     */
    public function setNameLibrary(string $library): void
    {
        $this->library = $library;
    }

}