<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\Persistence\World;

use Legends\Game\Domain\Util\Id\Id;
use Legends\Game\Domain\World\Location;
use function Lambdish\Phunctional\map;

final readonly class SerializeLocation
{
    public function __invoke(Location $location): array
    {
        return [
            'id' => (string) $location->getId(),
            'name' => $location->getName(),
            'type' => $location->getType()->value,
            'entrypoints' => map(static fn(Id $id): string => "$id", $location->getEntrypoints()),
        ];
    }
}
