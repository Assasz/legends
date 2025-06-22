<?php

declare(strict_types=1);

namespace Legends\Game\Domain\Inventory\Consumable;

interface Consumable extends \Stringable
{
    public function consume(): void;
}
