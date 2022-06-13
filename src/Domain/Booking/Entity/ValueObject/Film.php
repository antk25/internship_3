<?php

namespace App\Domain\Booking\Entity\ValueObject;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class Film
{
    #[ORM\Column(type: 'string')]
    private string $title;

    #[ORM\Column(type: 'film_duration')]
    private \DateInterval $duration;

    public function __construct(string $title, \DateInterval $duration)
    {
        $this->title = $title;
        $this->duration = $duration;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDuration(): \DateInterval
    {
        return $this->duration;
    }
}
