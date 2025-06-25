<?php

declare(strict_types=1);

namespace Legends\Game\Domain\Inventory\Equipment\Charm;

use Legends\Game\Domain\Util\DomainException;

final class CharmException extends DomainException
{
    private const string TITLE = 'Charm';

    public static function tooMany(): self
    {
        return new self('Cannot equip more than 5 charms', self::TITLE);
    }
}
