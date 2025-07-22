<?php

declare(strict_types=1);

namespace Legends\Game\Tests\User;

use Legends\Game\Domain\World\Location;
use Legends\Game\Infrastructure\Persistence\Adventurer\AdventurerRepository;
use Legends\Game\Infrastructure\Persistence\User\UserRepository;
use Legends\Game\Infrastructure\Persistence\World\LocationRepository;
use Legends\Game\Infrastructure\User\SignUp\SignUp;
use Legends\Game\Infrastructure\User\SignUp\SignUpException;
use Legends\Game\Infrastructure\User\UserException;
use Legends\Game\Infrastructure\User\UserToken;
use Legends\Game\Tests\LegendsApiTestCase;
use Legends\Game\Tests\World\LocationFactory;
use PHPUnit\Framework\Attributes\Test;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

final class UserTest extends LegendsApiTestCase
{
    #[Test]
    public function canSignUp(): void
    {
        /** @var LocationRepository $locationRepository */
        $locationRepository = $this->getContainer()->get(LocationRepository::class);
        $locationRepository->persist(LocationFactory::create(name: SignUp::STARTING_LOCATION));

        $response = $this->makeRequest('POST', '/user/signUp', json_encode([
            'adventurerName' => $adventurerName = 'John',
            'adventurerAvatar' => 'avatar_1',
            'email' => 'john@doe.com',
            'password' => '12345678',
        ]));

        $response = json_decode($response->getContent())->data;

        self::assertResponseStatusCodeSame(Response::HTTP_CREATED);
        self::assertIsString($response->token);

        /** @var UserRepository $userRepository */
        $userRepository = $this->getContainer()->get(UserRepository::class);
        $user = $userRepository->getByToken($response->token);

        /** @var AdventurerRepository $adventurerRepository */
        $adventurerRepository = $this->getContainer()->get(AdventurerRepository::class);
        $adventurer = $adventurerRepository->getById($user->getAdventurerId());

        self::assertSame($adventurerName, $adventurer->getName());
    }

    #[Test]
    public function cannotSignUpWithTooShortPassword(): void
    {
        $response = $this->makeRequest('POST', '/user/signUp', json_encode([
            'adventurerName' => 'John',
            'adventurerAvatar' => 'avatar_1.png',
            'email' => 'john@doe.com',
            'password' => '1234567',
        ]));

        self::assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        self::assertStringContainsString(SignUpException::passwordTooShort()->getMessage(), $response->getContent());
    }

    #[Test]
    public function canSignIn(): void
    {
        $this->persistUser($user = UserFactory::create(password: $password = '12345678'));

        $response = $this->makeRequest('POST', '/user/signIn', json_encode([
            'email' => $user->getEmail(),
            'password' => $password,
        ]));

        $response = json_decode($response->getContent())->data;

        self::assertResponseIsSuccessful();
        self::assertIsString($response->token);
    }

    #[Test]
    public function cannotSignInWithInvalidPassword(): void
    {
        $this->persistUser($user = UserFactory::create());

        $response = $this->makeRequest('POST', '/user/signIn', json_encode([
            'email' => $user->getEmail(),
            'password' => 'incorrect_password',
        ]));

        self::assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
        self::assertStringContainsString(UserException::invalidPassword()->getMessage(), $response->getContent());
    }

    #[Test]
    public function canGetInfo(): void
    {
        $this->persistUser($user = UserFactory::create(email: $email = 'john@doe.com'));

        $response = $this->makeRequestAs($user, 'GET', '/user/getInfo');
        $response = json_decode($response->getContent())->data;

        self::assertResponseIsSuccessful();
        self::assertSame($email, $response->email);
    }

    #[Test]
    public function missingToken(): void
    {
        $response = $this->makeRequest('GET', '/user/getInfo');

        self::assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
        self::assertStringContainsString(UserException::missingToken()->getMessage(), $response->getContent());
    }

    #[Test]
    public function invalidToken(): void
    {
        $response = $this->makeRequestAs($user = UserFactory::create(), 'GET', '/user/getInfo');

        self::assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
        self::assertStringContainsString(UserException::invalidToken((string) $user->getToken())->getMessage(), $response->getContent());
    }

    #[Test]
    public function expiredToken(): void
    {
        $this->persistUser($user = UserFactory::create(
            token: new UserToken($token = Uuid::uuid4()->toString(), new \DateTimeImmutable()->modify('-1 day'))
        ));

        $response = $this->makeRequestAs($user, 'GET', '/user/getInfo');

        self::assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
        self::assertStringContainsString(UserException::expiredToken($token)->getMessage(), $response->getContent());
    }
}
