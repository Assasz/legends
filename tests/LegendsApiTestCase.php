<?php

declare(strict_types=1);

namespace Legends\Game\Tests;

use Legends\Game\Infrastructure\Persistence\DatabaseClient;
use Legends\Game\Infrastructure\Persistence\User\UserRepository;
use Legends\Game\Infrastructure\User\GetUserFromRequest;
use Legends\Game\Infrastructure\User\User;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

abstract class LegendsApiTestCase extends WebTestCase
{
    protected readonly KernelBrowser $httpClient;

    protected function setUp(): void
    {
        $this->httpClient = static::createClient();

        /** @var DatabaseClient $databaseClient */
        $databaseClient = $this->httpClient->getContainer()->get(DatabaseClient::class);
        $databaseClient->dropDatabase();
    }

    protected function makeRequest(string $method, string $uri, string $content = '', array $headers = []): Response
    {
        $this->httpClient->request(
            $method,
            $uri,
            [],
            [],
            $headers,
            $content,
        );

        return $this->httpClient->getResponse();
    }

    protected function makeRequestAs(User $user, string $method, string $uri, string $content = '', array $headers = []): Response
    {
        return $this->makeRequest(
            $method,
            $uri,
            $content,
            array_merge($headers, ['HTTP_' . GetUserFromRequest::TOKEN_HEADER => (string) $user->getToken()]),
        );
    }

    protected function persistUser(User $user): void
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->getContainer()->get(UserRepository::class);
        $userRepository->persist($user);
    }
}
