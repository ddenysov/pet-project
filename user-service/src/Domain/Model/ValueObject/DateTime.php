<?php

namespace User\Domain\Model\ValueObject;

class DateTime
{
    /**
     * @var \DateTime
     */
    private readonly \DateTime $dateTime;

    public function __construct()
    {
        $this->dateTime = new \DateTime('now');
    }

    /**
     * @return \DateTime
     * @throws \Exception
     */
    public function toDateTime(): \DateTime
    {
        return $this->dateTime;
    }
}