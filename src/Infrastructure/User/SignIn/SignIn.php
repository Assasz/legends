<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\User\SignIn;

use Legends\Game\Infrastructure\Persistence\User\UserRepository;
use Legends\Game\Infrastructure\User\UserException;
use Legends\Game\Infrastructure\User\UserToken;

final readonly class SignIn
{
    public function __construct(
        private UserRepository $userRepository,
    ) {
    }

    public function  __invoke(string $email, #[\SensitiveParameter] string $password): UserToken
    {
        $user = $this->userRepository->getByEmail($email);
        if (password_verify($password, $user->getPassword()) === false) {
            throw UserException::invalidPassword();
        }

        $this->userRepository->updateToken($user->getId(), $token = UserToken::new());

        return $token;
    }
}
