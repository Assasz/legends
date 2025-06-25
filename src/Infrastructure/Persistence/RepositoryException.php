<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\Persistence;

use Legends\Game\Application\RepositoryException as Contract;
use Legends\Game\Domain\Util\Id\Id;

final class RepositoryException extends \RuntimeException implements Contract
{
    public static function notFoundById(Id $id, string $collection): self
    {
        return new self("Element from collection `$collection` with id `$id` not found.");
    }

    public static function notFoundByQuery(array $query, string $collection): self
    {
        return new self("Element from collection `$collection` not found by given query: " . json_encode($query));
    }
}
