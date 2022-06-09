<?php

namespace App\Domain\Booking\TransferObject;

use Symfony\Component\Validator\Constraints as Assert;

final class NewClientDto
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
    public string $phone;
}
