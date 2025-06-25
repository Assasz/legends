<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\User;

use Ramsey\Uuid\Uuid;

final readonly class UserToken implements \Stringable
{
    private const string EXPIRATION_MODIFIER = '+1 day';

    public function __construct(
        private string $value,
        private \DateTimeImmutable $expiresAt,
    ) {
    }

    public static function new(): self
    {
        return new self(Uuid::uuid4()->toString(), new \DateTimeImmutable()->modify(self::EXPIRATION_MODIFIER));
    }

    public function getExpiresAt(): \DateTimeImmutable
    {
        return $this->expiresAt;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
