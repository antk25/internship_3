<?php

namespace App\Tests\Unit\Domain\Booking\Entity\ValueObject;

use App\Domain\Booking\Entity\ValueObject\Client;
use PHPUnit\Framework\TestCase;

final class ClientTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testIfPhoneNumberEnteredIncorrectlyShouldGiveException(): void
    {
        $correctName = 'Федор';
        $wrongPhone = '452';

        $this->expectException(\Throwable::class);
        $this->expectExceptionMessage('Invalid phone format');
        new Client($correctName, $wrongPhone);
    }

    /**
     * @throws \Exception
     */
    public function testIfClientNameEnteredIncorrectlyShouldGiveException(): void
    {
        $wrongName = 'Фе';
        $correctPhone = '89526548978';

        $this->expectException(\Throwable::class);
        $this->expectExceptionMessage('Invalid name');

        new Client($wrongName, $correctPhone);
    }

    /**
     * @throws \Exception
     */
    public function testIfClientNameAndPhoneNumberEnteredCorrectlyShouldBeCreateObjectOfClientClass(): void
    {
        $correctName = 'Федор';
        $correctPhone = '89526548978';

        $client = new Client($correctName, $correctPhone);

        $this->assertInstanceOf(Client::class, $client);
    }
}
