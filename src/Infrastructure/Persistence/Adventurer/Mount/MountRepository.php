<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\Persistence\Adventurer\Mount;

use Legends\Game\Application\Adventurer\Mount\MountRepository as Contract;
use Legends\Game\Domain\Adventurer\Mount\Mount;
use Legends\Game\Domain\Util\Id\Id;
use Legends\Game\Infrastructure\Persistence\DatabaseClient;
use Legends\Game\Infrastructure\Persistence\RepositoryException;

final readonly class MountRepository implements Contract
{
    private const string COLLECTION = 'mounts';

    public function __construct(
        private DatabaseClient $databaseClient,
        private DeserializeMount $deserializeMount,
    ) {
    }

    public function getById(Id $id): Mount
    {
        $result = $this->databaseClient->getByQuery(
            self::COLLECTION,
            ['id' => "$id"],
        );

        if (empty($result)) {
            throw RepositoryException::notFoundById($id, self::COLLECTION);
        }

        return ($this->deserializeMount)(current($result));
    }
}
