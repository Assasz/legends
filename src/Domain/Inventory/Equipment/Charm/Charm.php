<?php

declare(strict_types=1);

namespace Legends\Game\Domain\Inventory\Equipment\Charm;

use Legends\Game\Domain\Inventory\InventoryItem;

final readonly class Charm implements InventoryItem
{
    public function __construct(
        private string $name,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
