<?php

declare(strict_types=1);

namespace Legends\Game\Application;

interface RepositoryException extends \Throwable
{
    public function getMessage(): string;
}
