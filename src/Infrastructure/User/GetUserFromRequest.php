<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\User;

use Legends\Game\Domain\Util\Id\Id;
use Symfony\Component\HttpFoundation\Request;

final class GetUserFromRequest
{
    public function __invoke(Request $request): User
    {
        // @todo: auth
        return new User(
            Id::new(),
            Id::new(),
            UserToken::new(),
        );
    }
}
