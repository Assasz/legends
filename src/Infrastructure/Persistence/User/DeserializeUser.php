<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\Persistence\User;

use Legends\Game\Domain\Util\ArrayValidator\ArrayValidator;
use Legends\Game\Domain\Util\ArrayValidator\ArrayValidatorException;
use Legends\Game\Domain\Util\Id\Id;
use Legends\Game\Infrastructure\Persistence\DeserializeException;
use Legends\Game\Infrastructure\User\User;
use Legends\Game\Infrastructure\User\UserToken;

final readonly class DeserializeUser
{
    public function __invoke(array $user): User
    {
        self::validate($user);

        $token = $user['token']->getArrayCopy();

        return new User(
            new Id($user['id']),
            new Id($user['adventurerId']),
            $user['email'],
            $user['password'],
            new UserToken(
                $token['value'],
                \DateTimeImmutable::createFromTimestamp($token['expiresAt']),
            ),
        );
    }

    private static function validate(array $user): void
    {
        try {
            ArrayValidator::makeSureValueIsSetUnderKey('id', $user);
            ArrayValidator::makeSureValueIsSetUnderKey('adventurerId', $user);
            ArrayValidator::makeSureValueIsSetUnderKey('email', $user);
            ArrayValidator::makeSureValueIsSetUnderKey('password', $user);
            ArrayValidator::makeSureValueIsSetUnderKey('token', $user);
            $token = $user['token']->getArrayCopy();
            ArrayValidator::makeSureValueIsSetUnderKey('value', $token);
            ArrayValidator::makeSureValueIsSetUnderKey('expiresAt', $token);
        } catch (ArrayValidatorException $exception) {
            throw DeserializeException::cannotDeserialize(User::class, $exception->getMessage());
        }
    }
}
