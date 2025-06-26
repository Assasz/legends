<?php

declare(strict_types=1);

namespace Legends\Game\Tests\World;

use Faker\Factory;
use Legends\Game\Domain\Util\Id\Id;
use Legends\Game\Domain\Util\Id\IdCollection;
use Legends\Game\Domain\World\Location;
use Legends\Game\Domain\World\LocationType;

final readonly class LocationFactory
{
    public static function create(
        ?string $name = null,
        ?LocationType $type = null,
        ?IdCollection $entrypoints = null,
    ): Location {
        $faker = Factory::create();

        return new Location(
            Id::new(),
            $name ?? $faker->word,
            $type ?? LocationType::JUNGLE,
            $entrypoints ?? new IdCollection(),
        );
    }
}
