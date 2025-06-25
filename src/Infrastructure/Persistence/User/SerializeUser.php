<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\Persistence\User;

use Legends\Game\Infrastructure\User\User;

final readonly class SerializeUser
{
    public function __invoke(User $user): array
    {
        return [
            'id' => (string) $user->getId(),
            'adventurerId' => (string) $user->getAdventurerId(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'token' => [
                'value' => (string) $user->getToken(),
                'expiresAt' => $user->getToken()->getExpiresAt()->getTimestamp(),
            ],
        ];
    }
}
