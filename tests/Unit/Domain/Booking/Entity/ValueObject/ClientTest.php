<?php

namespace App\Tests\Unit\Domain\Booking\Entity\ValueObject;

use App\Domain\Booking\Entity\ValueObject\Client;
use PHPUnit\Framework\TestCase;

final class ClientTest extends TestCase
{
    public function testThrowExceptionAnInvalidPhoneFormat(): void
    {
        $this->expectException(\Throwable::class);
        $this->expectExceptionMessage('Invalid phone format');
        new Client('Федор', '452');
    }

    /**
     * @throws \Exception
     */
    public function testThrowExceptionAnInvalidNameFormat(): void
    {
        $this->expectException(\Throwable::class);
        $this->expectExceptionMessage('Invalid name');

        new Client('Фе', '89526548978');
    }

    /**
     * @throws \Exception
     */
    public function testSuccessfullyCreateClient(): void
    {
        $client = new Client('Федор', '89526548978');
        $this->assertInstanceOf(Client::class, $client);
    }
}
