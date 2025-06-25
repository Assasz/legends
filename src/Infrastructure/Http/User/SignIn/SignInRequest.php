<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\Http\User\SignIn;

final readonly class SignInRequest
{
    public function __construct(
        private string $email,
        #[\SensitiveParameter] private string $password,
    ) {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
