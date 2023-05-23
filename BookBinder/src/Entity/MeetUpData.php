<?php

namespace App\Entity;

class MeetUpData
{
    private string $nameInvited;
    private DateTime $dateTime;
    private string $library;

    public function __construct(string $nameInvited, DateTime $dateTime, string $library){
        $this->nameInvited = $nameInvited;
        $this->dateTime = $dateTime;
        $this->library = $library;
    }



}