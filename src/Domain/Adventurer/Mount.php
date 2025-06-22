<?php

declare(strict_types=1);

namespace Legends\Game\Domain\Adventurer;

use Legends\Game\Domain\Util\Id\Id;
use Legends\Game\Domain\Util\IntegerValue\IntegerValue;

final readonly class Mount implements \Stringable
{
    public function __construct(
        private Id $id,
        protected string $name,
        protected IntegerValue $movePointsBonus,
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

    public function getMovePointsBonus(): IntegerValue
    {
        return $this->movePointsBonus;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
