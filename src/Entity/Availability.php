<?php

namespace App\Entity;

use DateTime;

class Availability
{
    protected DateTime $fromDate;
    protected DateTime $toDate;

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
