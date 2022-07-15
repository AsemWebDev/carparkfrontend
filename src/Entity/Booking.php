<?php

namespace App\Entity;

use DateTime;

class Booking
{
    protected string $username;
    protected DateTime $fromDate;
    protected DateTime $toDate;

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    public function getFromDate(): ?DateTime
    {
        return $this->fromDate;
    }

    public function setFromDate(?DateTime $fromDate): void
    {
        $this->fromDate = $fromDate;
    }

    public function getToDate(): ?DateTime
    {
        return $this->toDate;
    }

    public function setToDate(?DateTime $toDate): void
    {
        $this->toDate = $toDate;
    }
}
