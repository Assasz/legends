<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\Http\User\SignUp;

final readonly class SignUpRequest
{
    public function __construct(
        private string $adventurerName,
        private string $adventurerAvatar,
        private string $email,
        #[\SensitiveParameter] private string $password,
    ) {
    }

    public function getAdventurerName(): string
    {
        return $this->adventurerName;
    }

    public function getAdventurerAvatar(): string
    {
        return $this->adventurerAvatar;
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
