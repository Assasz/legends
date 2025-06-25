<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\Http\User\SignUp;

final readonly class SignUpRequest
{
    public function __construct(
        private string $adventurerName,
        private string $email,
        #[\SensitiveParameter] private string $password,
    ) {
    }

    public function getAdventurerName(): string
    {
        return $this->adventurerName;
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
