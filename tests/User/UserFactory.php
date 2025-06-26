<?php

declare(strict_types=1);

namespace Legends\Game\Tests\User;

use Faker\Factory;
use Legends\Game\Domain\Util\Id\Id;
use Legends\Game\Infrastructure\User\User;
use Legends\Game\Infrastructure\User\UserToken;

final readonly class UserFactory
{
    public static function create(
        ?string $email = null,
        ?string $password = null,
        ?UserToken $token = null,
    ): User {
        $faker = Factory::create();

        return new User(
            Id::new(),
            Id::new(),
            $email ?? $faker->email,
            password_hash($password ?? $faker->password, PASSWORD_BCRYPT),
            $token ?? UserToken::new(),
        );
    }
}
