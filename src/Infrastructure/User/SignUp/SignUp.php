<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\User\SignUp;

use Legends\Game\Domain\Adventurer\Adventurer;
use Legends\Game\Domain\Adventurer\Avatar;
use Legends\Game\Domain\Util\Id\Id;
use Legends\Game\Domain\Util\IntegerValue\IntegerValue;
use Legends\Game\Infrastructure\Persistence\Adventurer\AdventurerRepository;
use Legends\Game\Infrastructure\Persistence\User\UserRepository;
use Legends\Game\Infrastructure\Persistence\World\LocationRepository;
use Legends\Game\Infrastructure\User\User;
use Legends\Game\Infrastructure\User\UserToken;

final readonly class SignUp
{
    public const string STARTING_LOCATION = 'Hunters Camp';

    public function __construct(
        private LocationRepository $locationRepository,
        private AdventurerRepository $adventurerRepository,
        private UserRepository $userRepository,
    ) {
    }

    public function __invoke(
        string $adventurerName,
        string $adventurerAvatar,
        string $email,
        #[\SensitiveParameter] string $password
    ): User {
        if (strlen($password) < 8) {
            throw SignUpException::passwordTooShort();
        }

        $this->adventurerRepository->persist(new Adventurer(
            $adventurerId = Id::new(),
            $adventurerName,
            Avatar::from($adventurerAvatar),
            new IntegerValue(1),
            new IntegerValue(1),
            new IntegerValue(1),
            null,
            $this->locationRepository->getByName(self::STARTING_LOCATION)->getId(),
        ));

        $this->userRepository->persist($user = new User(
            Id::new(),
            $adventurerId,
            $email,
            password_hash($password, PASSWORD_BCRYPT),
            UserToken::new(),
        ));

        return $user;
    }
}
