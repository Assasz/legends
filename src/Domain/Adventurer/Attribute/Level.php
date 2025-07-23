<?php

declare(strict_types=1);

namespace Legends\Game\Domain\Adventurer\Attribute;

use Legends\Game\Domain\Util\IntegerValue\IntegerValue;

final class Level extends IntegerValue
{
    public function calculateExperienceNeededForNextLevel(): Experience
    {
        $experienceNeededForNextLevel = new Experience(0);
        foreach (range(1, $this->value + 1) as $number) {
            $experienceNeededForNextLevel->increaseBy(self::getRequiredExperience(new Level($number)));
        }

        return $experienceNeededForNextLevel;
    }

    private static function getRequiredExperience(Level $level): Experience
    {
        return match (true) {
            $level->isGreaterThan(new Level(10)) => new Experience(2000),
            $level->isGreaterThan(new Level(20)) => new Experience(3000),
            default => new Experience(1000),
        };
    }
}
