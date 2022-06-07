<?php

namespace App\Booking\Domain\TransferObject;

use Symfony\Component\Validator\Constraints as Assert;

class NewClientDto
{
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 3,
        max: 50,
        minMessage: 'Your first name must be at least {{ limit }} characters long',
        maxMessage: 'Your first name cannot be longer than {{ limit }} characters',
    )]
    public string $name;

    #[Assert\NotBlank]
    public string $phone;
}
