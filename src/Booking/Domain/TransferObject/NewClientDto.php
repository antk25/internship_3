<?php

namespace App\Booking\Domain\TransferObject;

use Symfony\Component\Validator\Constraints as Assert;

class NewClientDto
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
    public string $phone;
}
