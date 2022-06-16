<?php

namespace App\Domain\Booking\Entity\ValueObject;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class Client
{
    #[ORM\Column(type: 'string')]
    private string $name;

    #[ORM\Column(type: 'bigint')]
    private string $phone;

    /**
     * @throws \Exception
     */
    public function __construct(string $name, string $phone)
    {
        self::assertThatNameIsValid($name);
        self::assertThatPhoneIsValid($phone);

        $this->name = $name;
        $this->phone = $phone;
    }

    /**
     * @throws \Exception
     */
    private static function assertThatNameIsValid(string $name): void
    {
        if (!preg_match('/^[а-яё]{3,30}|[a-z]{3,30}$/iu', $name)) {
            throw new \Exception('Invalid name');
        }
    }

    /**
     * @throws \Exception
     */
    private static function assertThatPhoneIsValid(string $phone): void
    {
        if (!preg_match('/\+?[78][-(]?\d{3}\)?-?\d{3}-?\d{2}-?\d{2}$/m', $phone)) {
            throw new \Exception('Invalid phone format');
        }
    }
}
