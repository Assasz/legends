<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\User\SignUp;

use Legends\Game\Domain\Util\DomainException;

final class SignUpException extends DomainException
{
    private const string TITLE = 'Sign Up';

    public static function passwordTooShort(): self
    {
        return new self('Password has to be at least 8 characters long', self::TITLE);
    }
}
