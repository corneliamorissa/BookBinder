<?php

namespace App\Entity;

use DateTime;

class MeetUpData
{
    public string $name_invited;
    private DateTime $date_time;
    public string $library;
    public string $data_uri;

    public function __construct(string $name_invited, DateTime $date_time, string $library){


        $this-> date_time = $date_time;
        $this->name_invited = $name_invited;
        $this->library = $library;
    }

    /**
     * @return string
     */
    public function getNameInvited(): string
    {
        return $this->name_invited;
    }

    /**
     * @param string $name_invited
     */
    public function setNameUserInvited(string $name_invited): void
    {
        $this->name_invited = $name_invited;
    }

    /**
     * @return DateTime
     */
    public function getDateTime(): DateTime
    {
        return $this->date_time;
    }

    /**
     * @param DateTime $date_time
     */
    public function setDateTime(DateTime $date_time): void
    {
        $this->date_time = $date_time;
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

    /**
     * @return string
     */
    public function getDataUri(): string
    {
        return $this->data_uri;
    }

    /**
     * @param string $data_uri
     */
    public function setDataUri(string $data_uri): void
    {
        $this->data_uri = $data_uri;
    }

}