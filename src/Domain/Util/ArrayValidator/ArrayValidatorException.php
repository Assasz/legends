<?php

declare(strict_types=1);

namespace Legends\Game\Domain\Util\ArrayValidator;

final class ArrayValidatorException extends \RuntimeException
{
    public static function missingValueAtKey(string|int $key): self
    {
        return new self("Missing value at key: `$key`");
    }

    public static function missingKey(string|int $key): self
    {
        return new self("Missing key: `$key`");
    }

    public static function missingValue(mixed $value): self
    {
        return new self("Missing value: `$value`");
    }
}
