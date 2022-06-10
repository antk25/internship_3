<?php

namespace App\Domain\Booking\Entity\ValueObject;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class Film
{
    #[ORM\Column(type: 'string')]
    private string $filmName;

    #[ORM\Column(type: 'film_length')]
    private \DateInterval $filmLength;

    /**
     * @throws \Exception
     */
    public function __construct(string $filmName, \DateInterval $filmLength)
    {
        $this->filmName = $filmName;
        $this->filmLength = $filmLength;
    }

    public function getFilmName(): string
    {
        return $this->filmName;
    }

    /**
     * @throws \Exception
     */
    public function getFilmLength(): \DateInterval
    {
        return $this->filmLength;
    }
}
