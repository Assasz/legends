<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\User;

use Legends\Game\Domain\Util\Id\Id;
use Legends\Game\Infrastructure\Persistence\RepositoryException;
use Legends\Game\Infrastructure\Persistence\User\UserRepository;
use Symfony\Component\HttpFoundation\Request;

final readonly class GetUserFromRequest
{
    public const string TOKEN_HEADER = 'X-Authorization';

    public function __construct(
        private UserRepository $userRepository,
    ) {
    }

    public function __invoke(Request $request): User
    {
        $token = $request->headers->get(self::TOKEN_HEADER);
        if ($token === null) {
            throw UserException::missingToken();
        }

        try {
            $user = $this->userRepository->getByToken($token);
        } catch (RepositoryException) {
            throw UserException::invalidToken($token);
        }

        if ($user->getToken()->getExpiresAt()->getTimestamp() < time()) {
            throw UserException::expiredToken($token);
        }

        return $user;
    }
}
