<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\User;

final class UserException extends \RuntimeException
{
    public static function missingToken(): self
    {
        return new self(sprintf('Missing token under header `%s`', GetUserFromRequest::TOKEN_HEADER));
    }

    public static function invalidToken(string $token): self
    {
        return new self("User token `$token` is invalid");
    }

    public static function expiredToken(string $token): self
    {
        return new self("User token `$token` is expired");
    }

    public static function invalidPassword(): self
    {
        return new self('Invalid password');
    }
}
