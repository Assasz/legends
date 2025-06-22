<?php

declare(strict_types=1);

namespace Legends\Game\Domain\Inventory\Equipment\Charm;

use Legends\Game\Domain\Util\Collection\Collection;

final class CharmCollection extends Collection
{
    protected function getType(): string
    {
        return Charm::class;
    }

    protected static function validate(iterable $items): void
    {
        if (count($items) > 5) {
            throw CharmException::tooMany();
        }
    }
}
