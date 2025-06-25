<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\User;

use Legends\Game\Domain\Util\Id\Id;

final class UserException extends \RuntimeException
{
    public static function missingToken(): self
    {
        return new self(sprintf('Missing token under header `%s`', GetUserFromRequest::TOKEN_HEADER));
    }

    public static function invalidToken(Id $token): self
    {
        return new self("User token `$token` is invalid");
    }

    public static function expiredToken(Id $token): self
    {
        return new self("User token `$token` is expired");
    }

    public static function invalidPassword(): self
    {
        return new self('Invalid password');
    }
}
