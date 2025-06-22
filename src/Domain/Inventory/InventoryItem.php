<?php

declare(strict_types=1);

namespace Legends\Game\Domain\Inventory;

interface InventoryItem extends \Stringable
{
    public function getName(): string;
}
