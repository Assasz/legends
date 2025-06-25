<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\Http\User\SignUp;

use Legends\Game\Infrastructure\Http\DataResponse;
use Legends\Game\Infrastructure\User\SignUp\SignUp;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

final readonly class SignUpAPI
{
    public function  __construct(
        private SignUp $signUp,
    ) {
    }

    public function __invoke(#[MapRequestPayload] SignUpRequest $request): DataResponse
    {
        $user = ($this->signUp)($request->getAdventurerName(), $request->getEmail(), $request->getPassword());

        return new DataResponse(['token' => (string) $user->getToken()], Response::HTTP_CREATED);
    }
}
