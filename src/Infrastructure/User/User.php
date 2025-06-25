<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\User;

use Legends\Game\Domain\Util\Id\Id;

final readonly class User
{
    public function __construct(
        private Id $id,
        private Id $adventurerId,
        private string $email,
        private string $password,
        private UserToken $token,
    ) {
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getAdventurerId(): Id
    {
        return $this->adventurerId;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getToken(): UserToken
    {
        return $this->token;
    }
}
