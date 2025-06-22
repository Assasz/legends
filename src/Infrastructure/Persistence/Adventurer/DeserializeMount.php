<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\Persistence\Adventurer;

use Legends\Game\Domain\Adventurer\Mount;
use Legends\Game\Domain\Util\ArrayValidator\ArrayValidator;
use Legends\Game\Domain\Util\ArrayValidator\ArrayValidatorException;
use Legends\Game\Domain\Util\Id\Id;
use Legends\Game\Domain\Util\IntegerValue\IntegerValue;
use Legends\Game\Infrastructure\Persistence\DeserializeException;

final readonly class DeserializeMount
{
    public function __invoke(array $mount): Mount
    {
        self::validate($mount);

        return new Mount(
            new Id($mount['id']),
            $mount['name'],
            new IntegerValue($mount['movePointsMultiplier']),
        );
    }

    private static function validate(array $mount): void
    {
        try {
            ArrayValidator::makeSureValueIsSetUnderKey('id', $mount);
            ArrayValidator::makeSureValueIsSetUnderKey('name', $mount);
            ArrayValidator::makeSureValueIsSetUnderKey('movePointsMultiplier', $mount);
        } catch (ArrayValidatorException $exception) {
            throw DeserializeException::cannotDeserialize(Mount::class, $exception->getMessage());
        }
    }
}
