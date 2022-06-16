<?php

namespace App\Tests\Unit\Domain\Booking\Entity\ValueObject;

use App\Domain\Booking\Entity\ValueObject\Film;
use PHPUnit\Framework\TestCase;

final class FilmTest extends TestCase
{
    public function setUp(): void
    {
        $this->film = new Film('Аватар', date_interval_create_from_date_string('180 minutes'));
    }

    public function testCreateFilm(): void
    {
        $this->assertInstanceOf(Film::class, $this->film);
    }

    public function testGetTitle(): void
    {
        $this->assertEquals('Аватар', $this->film->getTitle());
    }

    public function testGetDuration(): void
    {
        $this->assertEquals(date_interval_create_from_date_string('180 minutes'), $this->film->getDuration());
    }
}
