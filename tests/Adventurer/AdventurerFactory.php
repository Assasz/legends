<?php

declare(strict_types=1);

namespace Legends\Game\Tests\Adventurer;

use Faker\Factory;
use Legends\Game\Domain\Adventurer\Adventurer;
use Legends\Game\Domain\Adventurer\Avatar;
use Legends\Game\Domain\Util\Id\Id;
use Legends\Game\Domain\Util\IntegerValue\IntegerValue;

final readonly class AdventurerFactory
{
    public static function create(
        ?IntegerValue $movePoints = null,
        ?Id $locationId = null,
    ): Adventurer {
        $faker = Factory::create();

        return new Adventurer(
            Id::new(),
            $faker->name,
            Avatar::AVATAR_1,
            new IntegerValue(1),
            $movePoints ?? new IntegerValue(1),
            new IntegerValue(1),
            null,
            $locationId ?? Id::new(),
        );
    }
}
