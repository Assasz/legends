<?php

declare(strict_types=1);

namespace Legends\Game\Domain\Inventory\Equipment\Charm;

use Legends\Game\Domain\Inventory\InventoryItem;

abstract readonly class Charm implements InventoryItem
{
    public function __construct(
        protected string $name,
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
