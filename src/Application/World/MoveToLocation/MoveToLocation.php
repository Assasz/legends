<?php

declare(strict_types=1);

namespace Legends\Game\Application\World\MoveToLocation;

use Legends\Game\Application\Adventurer\AdventurerRepository;
use Legends\Game\Application\World\LocationRepository;
use Legends\Game\Domain\Util\Id\Id;
use Legends\Game\Domain\Util\IntegerValue\IntegerValue;

final readonly class MoveToLocation
{
    public function __construct(
        private AdventurerRepository $adventurerRepository,
        private LocationRepository $locationRepository,
    ) {
    }

    public function __invoke(Id $adventurerId, Id $destinationId): void
    {
        $adventurer = $this->adventurerRepository->getById($adventurerId);

        if ($adventurer->getMovePoints()->isLowerThan(new IntegerValue(1))) {
            throw MoveToLocationException::insufficientMovePoints();
        }

        $destination = $this->locationRepository->getById($destinationId);
        if ($destination->getEntrypoints()->filter(
            static fn(Id $id): bool => $id->equals($adventurer->getLocationId()),
        )->isEmpty()) {
            throw MoveToLocationException::unreachableDestination("$destination");
        }

        $adventurer->changeLocation($destinationId);
        $adventurer->getMovePoints()->decrement();

        $this->adventurerRepository->persist($adventurer);
    }
}
