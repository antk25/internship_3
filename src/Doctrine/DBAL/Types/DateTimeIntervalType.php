<?php

namespace App\Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\IntegerType;

final class DateTimeIntervalType extends IntegerType
{
    public const NAME = 'film_length';

    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     *
     * @param mixed $value
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): int
    {
        return $value instanceof \DateInterval ? $value->i : $value;
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     *
     * @param int $value
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): \DateInterval
    {
        return \DateInterval::createFromDateString($value . 'minutes');
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
