<?php

namespace App\Tests\Unit\Domain\Booking\Command;

use App\Domain\Booking\Command\BookTicketCommand;
use App\Domain\Booking\Entity\FilmSession;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class BookTicketCommandTest extends TestCase
{
    private ValidatorInterface $validator;

    public function setUp(): void
    {
        parent::setUp();

        $this->validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();
    }

    public function testCreationCommandIfFormatNameIsIncorrectShouldOutputError(): void
    {
        $mockFilmSession = $this->createMock(FilmSession::class);

        $newCommand = new BookTicketCommand($mockFilmSession);
        $newCommand->name = 'Фе';
        $newCommand->phone = '89563564585';
        $errors = $this->validator->validate($newCommand);

        $this->assertGreaterThan(0, count($errors));
    }

    public function testCreationCommandIfFormatPhoneIsIncorrectShouldOutputError(): void
    {
        $mockFilmSession = $this->createMock(FilmSession::class);

        $newCommand = new BookTicketCommand($mockFilmSession);
        $newCommand->name = 'Федор';
        $newCommand->phone = '8585';
        $errors = $this->validator->validate($newCommand);

        $this->assertGreaterThan(0, count($errors));
    }
}
