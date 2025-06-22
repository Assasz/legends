<?php

declare(strict_types=1);

namespace Legends\Game\Domain\Inventory;

use Legends\Game\Domain\Inventory\Consumable\Consumable;
use Legends\Game\Domain\Util\Collection\Collection;

final class Inventory extends Collection
{
    protected function getType(): string
    {
        return InventoryItem::class;
    }

    public function filterConsumable(): self
    {
        return $this->filter(
            static fn(InventoryItem $inventoryItem): bool => $inventoryItem instanceof Consumable,
        );
    }
}
