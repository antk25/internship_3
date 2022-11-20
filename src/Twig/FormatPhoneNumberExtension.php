<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class FormatPhoneNumberExtension extends AbstractExtension
{
    private const PHONE_TEMPLATE = '%s (%s) %s-%s-%s';

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

        $phoneNumbers = str_split($phone);
        $countryCode = array_slice($phoneNumbers, 0, 1);

        if ((int) $countryCode[0] === 7) {
            array_unshift($countryCode, '+');
        }

        $code = array_slice($phoneNumbers, 1, 3);
        $group1 = array_slice($phoneNumbers, 4, 3);
        $group2 = array_slice($phoneNumbers, 7, 2);
        $group3 = array_slice($phoneNumbers, 9, 2);

        // вариант 1
        return sprintf(
            self::PHONE_TEMPLATE,
            implode($countryCode),
            implode($code),
            implode($group1),
            implode($group2),
            implode($group3),
        );

        // вариант 2 - раскомментировать и закоменнтировать варинат 1
//        $countryCode[] = ' (';
//        $code[] = ') ';
//        $group1[] = '-';
//        $group2[] = '-';
//
//        $result = array_merge($countryCode, $code, $group1, $group2, $group3);
//
//        return implode($result);
    }

    private function assertPhoneNumber(string $phone): bool
    {
        $lengthOfNumber = strlen($phone);

        return $lengthOfNumber === 11;
    }
}
