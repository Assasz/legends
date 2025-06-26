<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\Http\World\MoveToLocation;

use Legends\Game\Application\World\MoveToLocation\MoveToLocation;
use Legends\Game\Domain\Util\Id\Id;
use Legends\Game\Infrastructure\Http\NoContentResponse;
use Legends\Game\Infrastructure\User\GetUserFromRequest;
use Symfony\Component\HttpFoundation\Request;

final readonly class MoveToLocationAPI
{
    public function  __construct(
        private GetUserFromRequest $getUserFromRequest,
        private MoveToLocation $moveToLocation,
    ) {
    }

    public function __invoke(Request $request, string $locationId): NoContentResponse
    {
        $user = ($this->getUserFromRequest)($request);
        $locationId = new Id($locationId);

        ($this->moveToLocation)($user->getAdventurerId(), $locationId);

        return new NoContentResponse();
    }
}
