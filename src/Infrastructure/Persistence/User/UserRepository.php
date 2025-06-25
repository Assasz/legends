<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\Persistence\User;

use Legends\Game\Domain\Util\Id\Id;
use Legends\Game\Infrastructure\Persistence\DatabaseClient;
use Legends\Game\Infrastructure\Persistence\RepositoryException;
use Legends\Game\Infrastructure\User\User;
use Legends\Game\Infrastructure\User\UserToken;

final readonly class UserRepository
{
    private const string COLLECTION = 'users';

    public function __construct(
        private DatabaseClient $databaseClient,
        private DeserializeUser $deserializeUser,
        private SerializeUser $serializeUser,
    ) {
    }

    public function getByToken(Id $token): User
    {
        $result = $this->databaseClient->getByQuery(
            self::COLLECTION,
            $query = ['token' => "$token"],
        );

        if (empty($result)) {
            throw RepositoryException::notFoundByQuery($query, self::COLLECTION);
        }

        return ($this->deserializeUser)(current($result));
    }

    public function getByEmail(string $email): User
    {
        $result = $this->databaseClient->getByQuery(
            self::COLLECTION,
            $query = ['email' => $email],
        );

        if (empty($result)) {
            throw RepositoryException::notFoundByQuery($query, self::COLLECTION);
        }

        return ($this->deserializeUser)(current($result));
    }

    public function persist(User $user): void
    {
        $this->databaseClient->upsert(
            self::COLLECTION,
            ['id' => (string) $user->getId()],
            ($this->serializeUser)($user),
        );
    }

    public function updateToken(Id $userId, UserToken $token): void
    {
        $this->databaseClient->updateOne(
            self::COLLECTION,
            ['id' =>  (string) $userId],
            ['$set' => ['token.value' => "$token", 'token.expiresAt' => $token->getExpiresAt()->getTimestamp()]],
        );
    }
}
