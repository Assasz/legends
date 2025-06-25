<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\Persistence\World;

use Legends\Game\Application\World\LocationRepository as Contract;
use Legends\Game\Domain\Util\Id\Id;
use Legends\Game\Domain\World\Location;
use Legends\Game\Infrastructure\Persistence\DatabaseClient;
use Legends\Game\Infrastructure\Persistence\RepositoryException;

final readonly class LocationRepository implements Contract
{
    private const string COLLECTION = 'locations';

    public function __construct(
        private DatabaseClient $databaseClient,
        private DeserializeLocation $deserializeLocation,
        private SerializeLocation $serializeLocation,
    ) {
    }

    public function getById(Id $id): Location
    {
        $result = $this->databaseClient->getByQuery(
            self::COLLECTION,
            ['id' => "$id"],
        );

        if (empty($result)) {
            throw RepositoryException::notFoundById($id, self::COLLECTION);
        }

        return ($this->deserializeLocation)(current($result));
    }

    public function getByName(string $name): Location
    {
        $result = $this->databaseClient->getByQuery(
            self::COLLECTION,
            $query = ['name' => $name],
        );

        if (empty($result)) {
            throw RepositoryException::notFoundByQuery($query, self::COLLECTION);
        }

        return ($this->deserializeLocation)(current($result));
    }

    public function persist(Location $location): void
    {
        $this->databaseClient->upsert(
            self::COLLECTION,
            ['id' => (string) $location->getId()],
            ($this->serializeLocation)($location),
        );
    }
}
