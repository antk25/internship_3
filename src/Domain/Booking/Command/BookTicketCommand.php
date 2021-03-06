<?php

namespace App\Domain\Booking\Command;

use App\Domain\Booking\Entity\FilmSession;
use Symfony\Component\Validator\Constraints as Assert;

final class BookTicketCommand
{
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 3,
        max: 50,
        minMessage: 'Длина вашего имени должна составлять не менее {{ limit }} символов',
        maxMessage: 'Ваше имя не может быть длиннее {{ limit}} символов',
    )]
    public string $name;

    #[Assert\NotBlank]
    #[Assert\Regex(
        '/[78][-(]?\d{3}\)?-?\d{3}-?\d{2}-?\d{2}$/m',
        message: 'Неправильный формат номера телефона',
    )]
    public int $phone;

    public function __construct(public readonly FilmSession $filmSession)
    {
    }
}
