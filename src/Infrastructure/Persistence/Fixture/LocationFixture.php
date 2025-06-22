<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\Persistence\Fixture;

use Legends\Game\Domain\Util\Id\Id;
use Legends\Game\Domain\Util\Id\IdCollection;
use Legends\Game\Domain\World\Location;
use Legends\Game\Domain\World\LocationType;

final readonly class LocationFixture
{
    public static function yield(): array
    {
        return [
            new Location(
                $huntersCampId = Id::new(),
                'Hunters Camp',
                LocationType::CITY,
                new IdCollection(),
            ),
            new Location(
                Id::new(),
                'Outer Forest',
                LocationType::JUNGLE,
                new IdCollection([$huntersCampId]),
            ),
        ];
    }
}
