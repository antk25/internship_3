<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class FormatPhoneNumberExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('phone', [$this, 'formatPhone']),
        ];
    }

    public function formatPhone(string $phone): string
    {
        $phone = trim($phone);
        $phone = str_replace('+', '', $phone);

        if (!$this->assertPhoneNumber($phone)) {
            return $phone;
        }

        return '+' . $phone;
    }

    private function assertPhoneNumber(string $phone): bool
    {
        $lengthOfNumber = strlen($phone);

        return $lengthOfNumber === 11;
    }
}
