<?php

declare(strict_types=1);

namespace Legends\Game\Domain\Util;

abstract class DomainException extends \DomainException
{
    public function __construct(
        string $message,
        protected readonly string $type,
    ) {
        parent::__construct($message);
    }

    public function getType(): string
    {
        return $this->type;
    }
}
