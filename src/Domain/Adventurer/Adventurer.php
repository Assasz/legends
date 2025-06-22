<?php

declare(strict_types=1);

namespace Legends\Game\Domain\Adventurer;

use Legends\Game\Domain\Inventory\Equipment\Equipment;
use Legends\Game\Domain\Inventory\Inventory;
use Legends\Game\Domain\Util\Id\Id;
use Legends\Game\Domain\Util\IntegerValue\IntegerValue;

final class Adventurer implements \Stringable
{
    public function __construct(
        private Id $id,
        private string $name,
        private IntegerValue $level,
//        private array $party,
        private IntegerValue $movePoints,
        private IntegerValue $maximumMovePoints,
        private ?Id $mountId,
//        private Equipment $equipment,
//        private Inventory $inventory,
//        private IntegerValue $health,
//        private IntegerValue $maximumHealth,
//        private IntegerValue $stamina,
//        private IntegerValue $skillPoints,
//        private array $combatSkills,
//        private array $adventureSkills,
        private Id $locationId,
    ) {
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return IntegerValue
     */
    public function getLevel(): IntegerValue
    {
        return $this->level;
    }

    public function getMovePoints(): IntegerValue
    {
        return $this->movePoints;
    }

    public function getMaximumMovePoints(): IntegerValue
    {
        return $this->maximumMovePoints;
    }

    public function getMountId(): ?Id
    {
        return $this->mountId;
    }

    public function getLocationId(): Id
    {
        return $this->locationId;
    }

    public function changeLocation(Id $locationId): void
    {
        $this->locationId = $locationId;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
