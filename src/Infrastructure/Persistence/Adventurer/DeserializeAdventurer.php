<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\Persistence\Adventurer;

use Legends\Game\Domain\Adventurer\Adventurer;
use Legends\Game\Domain\Util\ArrayValidator\ArrayValidator;
use Legends\Game\Domain\Util\ArrayValidator\ArrayValidatorException;
use Legends\Game\Domain\Util\Id\Id;
use Legends\Game\Domain\Util\IntegerValue\IntegerValue;
use Legends\Game\Infrastructure\Persistence\DeserializeException;

final class DeserializeAdventurer
{
    public function __invoke(array $adventurer): Adventurer
    {
        self::validate($adventurer);

        return new Adventurer(
            new Id($adventurer['id']),
            $adventurer['name'],
            new IntegerValue($adventurer['level']),
            new IntegerValue($adventurer['movePoints']),
            new IntegerValue($adventurer['maximumMovePoints']),
            $adventurer['mountId'] ? new Id($adventurer['mountId']) : null,
            new Id($adventurer['locationId']),
        );
    }

    private static function validate(array $adventurer): void
    {
        try {
            ArrayValidator::makeSureValueIsSetUnderKey('id', $adventurer);
            ArrayValidator::makeSureValueIsSetUnderKey('name', $adventurer);
            ArrayValidator::makeSureValueIsSetUnderKey('level', $adventurer);
            ArrayValidator::makeSureValueIsSetUnderKey('movePoints', $adventurer);
            ArrayValidator::makeSureValueIsSetUnderKey('maximumMovePoints', $adventurer);
            ArrayValidator::makeSureKeyIsSet('mountId', $adventurer);
            ArrayValidator::makeSureValueIsSetUnderKey('locationId', $adventurer);
        } catch (ArrayValidatorException $exception) {
            throw DeserializeException::cannotDeserialize(Adventurer::class, $exception->getMessage());
        }
    }
}
