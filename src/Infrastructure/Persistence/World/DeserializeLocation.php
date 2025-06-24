<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\Persistence\World;

use Legends\Game\Domain\Adventurer\Mount;
use Legends\Game\Domain\Util\ArrayValidator\ArrayValidator;
use Legends\Game\Domain\Util\ArrayValidator\ArrayValidatorException;
use Legends\Game\Domain\Util\Id\Id;
use Legends\Game\Domain\Util\Id\IdCollection;
use Legends\Game\Domain\World\Location;
use Legends\Game\Domain\World\LocationType;
use Legends\Game\Infrastructure\Persistence\DeserializeException;

final readonly class DeserializeLocation
{
    public function __invoke(array $location): Location
    {
        self::validate($location);

        return new Location(
            new Id($location['id']),
            $location['name'],
            LocationType::from($location['type']),
            new IdCollection(array_map(static fn(string $id): Id => new Id($id), $location['entrypoints'])),
        );
    }

    private static function validate(array $location): void
    {
        try {
            ArrayValidator::makeSureValueIsSetUnderKey('id', $location);
            ArrayValidator::makeSureValueIsSetUnderKey('name', $location);
            ArrayValidator::makeSureValueIsSetUnderKey('type', $location);
            ArrayValidator::makeSureValueIsSetUnderKey('entrypoints', $location);
        } catch (ArrayValidatorException $exception) {
            throw DeserializeException::cannotDeserialize(Location::class, $exception->getMessage());
        }
    }
}
