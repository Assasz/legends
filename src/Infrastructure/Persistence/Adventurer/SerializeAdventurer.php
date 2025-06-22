<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\Persistence\Adventurer;

use Legends\Game\Domain\Adventurer\Adventurer;

final readonly class SerializeAdventurer
{
    public function __invoke(Adventurer $adventurer): array
    {
        return [
            'id' => (string) $adventurer->getId(),
            'name' => $adventurer->getName(),
            'level' => $adventurer->getLevel()->get(),
            'movePoints' => $adventurer->getMovePoints()->get(),
            'maximumMovePoints' => $adventurer->getMaximumMovePoints()->get(),
            'mountId' => $adventurer->getMountId() ? (string) $adventurer->getMountId() : null,
            'locationId' => (string) $adventurer->getLocationId(),
        ];
    }
}
