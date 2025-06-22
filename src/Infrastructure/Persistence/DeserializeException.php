<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\Persistence;

use Legends\Game\Domain\Adventurer\Mount;

final class DeserializeException extends \RuntimeException
{
    public static function cannotDeserialize(string $className, string $detail): self
    {
        return new self("Cannot deserialize `$className`: $detail");
    }
}
