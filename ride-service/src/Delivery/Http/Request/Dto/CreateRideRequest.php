<?php

namespace Ride\Delivery\Http\Request\Dto;

use Common\Delivery\Http\Request\Dto\Dto;
use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CreateRideRequest extends Dto
{
    #[Assert\Required]
    public string $name;

    #[Assert\Email]
    public $description;

    #[Assert\DateTime]
    public DateTimeInterface $date;

    #[Assert\DateTime]
    public DateTimeInterface $time_start;

    #[Assert\DateTime]
    public DateTimeInterface $time_end;

    #[Assert\NotBlank]
    public string $image;

    #[Assert\NotBlank]
    public array $start_location;

    #[Assert\NotBlank]
    public array $finish_location;

    /**
     * @param string $name
     * @param string $description
     * @param DateTimeInterface $date
     * @param string $time_start
     * @param string $time_end
     * @param string $image
     * @param array $start_location
     * @param array $finish_location
     */
    public function __construct(string $name, $description, DateTimeInterface $date, string $time_start, string $time_end, string $image, array $start_location, array $finish_location)
    {
        $this->name            = $name;
        $this->description     = $description;
        $this->date            = $date;
        $this->time_start      = $time_start;
        $this->time_end        = $time_end;
        $this->image           = $image;
        $this->start_location  = $start_location;
        $this->finish_location = $finish_location;
    }


}