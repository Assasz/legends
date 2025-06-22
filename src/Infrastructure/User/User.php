<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\User;

use Legends\Game\Domain\Util\Id\Id;

final readonly class User
{
    public function __construct(
        private Id $id,
        private Id $adventurerId,
        private UserToken $token,
    ) {
    }

    public function getAdventurerId(): Id
    {
        return $this->adventurerId;
    }
}
