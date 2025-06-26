<?php

declare(strict_types=1);

namespace Legends\Game\Tests\World;

use Legends\Game\Application\World\MoveToLocation\MoveToLocationException;
use Legends\Game\Domain\Util\Id\IdCollection;
use Legends\Game\Domain\Util\IntegerValue\IntegerValue;
use Legends\Game\Infrastructure\Persistence\Adventurer\AdventurerRepository;
use Legends\Game\Infrastructure\Persistence\World\LocationRepository;
use Legends\Game\Tests\Adventurer\AdventurerFactory;
use Legends\Game\Tests\LegendsApiTestCase;
use Legends\Game\Tests\User\UserFactory;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpFoundation\Response;

final class LocationTest extends LegendsApiTestCase
{
    #[Test]
    public function canMoveToLocation(): void
    {
        /** @var LocationRepository $locationRepository */
        $locationRepository = $this->getContainer()->get(LocationRepository::class);
        $locationRepository->persist($currentLocation = LocationFactory::create());
        $locationRepository->persist($destination = LocationFactory::create(
            entrypoints: new IdCollection([$currentLocation->getId()]),
        ));

        /** @var AdventurerRepository $adventurerRepository */
        $adventurerRepository = $this->getContainer()->get(AdventurerRepository::class);
        $adventurerRepository->persist($adventurer = AdventurerFactory::create(
            movePoints: new IntegerValue(1),
            locationId: $currentLocation->getId(),
        ));

        $this->persistUser($user = UserFactory::create(adventurerId:  $adventurer->getId()));

        $this->makeRequestAs($user, 'POST', "/world/moveToLocation/{$destination->getId()}");

        self::assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);

        $adventurer = $adventurerRepository->getById($adventurer->getId());

        self::assertTrue($adventurer->getLocationId()->equals($destination->getId()));
        self::assertTrue($adventurer->getMovePoints()->equals(new IntegerValue(0)));
    }

    #[Test]
    public function cannotMoveToLocationIfInsufficientMovePoints(): void
    {
        /** @var LocationRepository $locationRepository */
        $locationRepository = $this->getContainer()->get(LocationRepository::class);
        $locationRepository->persist($currentLocation = LocationFactory::create());
        $locationRepository->persist($destination = LocationFactory::create(
            entrypoints: new IdCollection([$currentLocation->getId()]),
        ));

        /** @var AdventurerRepository $adventurerRepository */
        $adventurerRepository = $this->getContainer()->get(AdventurerRepository::class);
        $adventurerRepository->persist($adventurer = AdventurerFactory::create(
            movePoints: new IntegerValue(0),
            locationId: $currentLocation->getId(),
        ));

        $this->persistUser($user = UserFactory::create(adventurerId:  $adventurer->getId()));

        $response = $this->makeRequestAs($user, 'POST', "/world/moveToLocation/{$destination->getId()}");

        self::assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        self::assertStringContainsString(MoveToLocationException::insufficientMovePoints()->getMessage(), $response->getContent());
    }

    #[Test]
    public function cannotMoveToUnreachableLocation(): void
    {
        /** @var LocationRepository $locationRepository */
        $locationRepository = $this->getContainer()->get(LocationRepository::class);
        $locationRepository->persist($currentLocation = LocationFactory::create());
        $locationRepository->persist($destination = LocationFactory::create());

        /** @var AdventurerRepository $adventurerRepository */
        $adventurerRepository = $this->getContainer()->get(AdventurerRepository::class);
        $adventurerRepository->persist($adventurer = AdventurerFactory::create(
            movePoints: new IntegerValue(1),
            locationId: $currentLocation->getId(),
        ));

        $this->persistUser($user = UserFactory::create(adventurerId:  $adventurer->getId()));

        $response = $this->makeRequestAs($user, 'POST', "/world/moveToLocation/{$destination->getId()}");

        self::assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        self::assertStringContainsString(MoveToLocationException::unreachableDestination("$destination")->getMessage(), $response->getContent());
    }
}
