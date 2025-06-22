<?php

declare(strict_types=1);

namespace Legends\Game\Domain\Util\ArrayValidator;

final readonly class ArrayValidator
{
    public static function makeSureValueIsSetUnderKey(string|int $key, array $array): void
    {
        if (isset($array[$key]) === false) {
            throw ArrayValidatorException::missingValueAtKey($key);
        }
    }

    public static function makeSureKeyIsSet(string|int $key, array $array): void
    {
        if (array_key_exists($key, $array) === false) {
            throw ArrayValidatorException::missingKey($key);
        }
    }

    public static function makeSureValueIsSet(mixed $value, array $array): void
    {
        if (in_array($value, $array) === false) {
            throw ArrayValidatorException::missingValue($value);
        }
    }
}
