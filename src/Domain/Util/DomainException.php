<?php

declare(strict_types=1);

namespace Legends\Game\Domain\Util;

abstract class DomainException extends \DomainException
{
    public function __construct(
        string $message,
        protected string $type {
            get {}
        }
    ) {
        parent::__construct($message);
    }
}
