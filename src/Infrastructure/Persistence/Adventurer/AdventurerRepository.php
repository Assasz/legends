<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\Persistence\Adventurer;

use Legends\Game\Application\Adventurer\AdventurerRepository as Contract;
use Legends\Game\Domain\Adventurer\Adventurer;
use Legends\Game\Domain\Util\Id\Id;
use Legends\Game\Infrastructure\Persistence\DatabaseClient;
use Legends\Game\Infrastructure\Persistence\RepositoryException;

final readonly class AdventurerRepository implements Contract
{
    private const string COLLECTION = 'adventurers';

    public function __construct(
        private DatabaseClient $databaseClient,
        private DeserializeAdventurer $deserializeAdventurer,
        private SerializeAdventurer $serializeAdventurer,
    ) {
    }

    public function getById(Id $id): Adventurer
    {
        $result = $this->databaseClient->getByQuery(
            self::COLLECTION,
            ['id' => "$id"],
        );

        if (empty($result)) {
            throw RepositoryException::notFoundById($id, self::COLLECTION);
        }

        return ($this->deserializeAdventurer)(current($result));
    }

    public function persist(Adventurer $adventurer): void
    {
        $this->databaseClient->upsert(
            self::COLLECTION,
            ['id' => (string) $adventurer->getId()],
            ($this->serializeAdventurer)($adventurer),
        );
    }
}
