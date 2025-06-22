<?php

namespace Legends\Game\Domain\Inventory\Equipment;

use Legends\Game\Domain\Inventory\Equipment\Charm\CharmCollection;

final readonly class Equipment
{
    public function __construct(
        private object $weapon,
        private object $secondary,
        private object $armor,
        private object $helmet,
        private object $gauntlets,
        private object $boots,
        private CharmCollection $charms,
    ) {
    }
}