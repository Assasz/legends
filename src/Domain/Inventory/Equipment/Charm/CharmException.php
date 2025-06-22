<?php

declare(strict_types=1);

namespace Legends\Game\Domain\Inventory\Equipment\Charm;

final class CharmException extends \DomainException
{
    public static function tooMany(): self
    {
        return new self('Cannot equip more than 5 charms');
    }
}
