<?php

declare(strict_types=1);

namespace Legends\Game\Domain\Util\Collection;

final class CollectionException extends \RuntimeException
{
    public static function invalidType(string $givenType, string $expectedType): self
    {
        return new self("The object {$givenType} is not an instance of {$expectedType}");
    }

    public static function emptyCollection(): self
    {
        return new self('There is no elements in the collection');
    }
}
