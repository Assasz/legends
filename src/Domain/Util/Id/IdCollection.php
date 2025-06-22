<?php

declare(strict_types=1);

namespace Legends\Game\Domain\Util\Id;

use Legends\Game\Domain\Util\Collection\Collection;

final class IdCollection extends Collection
{
    protected function getType(): string
    {
        return Id::class;
    }
}
