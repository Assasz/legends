<?php

declare(strict_types=1);

namespace Legends\Game\Application\World\MoveToLocation;

use Legends\Game\Domain\Util\DomainException;

final class MoveToLocationException extends DomainException
{
    private const string TYPE = 'MoveToLocation';

    public static function insufficientMovePoints(): self
    {
        return new self('Insufficient move points', self::TYPE);
    }

    public static function unreachableDestination(string $locationName): self
    {
        return new self("Destination `$locationName` is unreachable", self::TYPE);
    }
}
