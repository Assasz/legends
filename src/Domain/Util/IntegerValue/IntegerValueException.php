<?php

declare(strict_types=1);

namespace Legends\Game\Domain\Util\IntegerValue;

final class IntegerValueException extends \RuntimeException
{
    public static function invalidValue(int $value): self
    {
        return new self("{$value} is not a valid value");
    }

    public static function onlyPositive(): self
    {
        return new self('Only positive integers are accepted');
    }
}
