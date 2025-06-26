<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\Http\User\GetInfo;

use Legends\Game\Infrastructure\Http\DataResponse;
use Legends\Game\Infrastructure\User\GetUserFromRequest;
use Symfony\Component\HttpFoundation\Request;

final readonly class GetInfoAPI
{
    public function __construct(
        private GetUserFromRequest $getUserFromRequest,
    ) {
    }

    public function __invoke(Request $request): DataResponse
    {
        $user = ($this->getUserFromRequest)($request);

        return new DataResponse([
            'id' => (string) $user->getId(),
            'adventurerId' => (string) $user->getAdventurerId(),
            'email' => $user->getEmail(),
        ]);
    }
}
