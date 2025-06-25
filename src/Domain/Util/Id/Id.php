<?php

declare(strict_types=1);

namespace Legends\Game\Domain\Util\Id;

use Ramsey\Uuid\Uuid;

final readonly class Id implements \Stringable
{
    public function __construct(
        protected string $id,
    ) {
    }

    public static function new(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    public function equals(Id $id): bool
    {
        return "$id" === $this->id;
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
