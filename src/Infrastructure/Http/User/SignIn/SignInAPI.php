<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\Http\User\SignIn;

use Legends\Game\Infrastructure\Http\DataResponse;
use Legends\Game\Infrastructure\User\SignIn\SignIn;

final readonly class SignInAPI
{
    public function  __construct(
        private SignIn $signIn,
    ) {
    }

    public function __invoke(SignInRequest $request): DataResponse
    {
        $token = ($this->signIn)($request->getEmail(), $request->getPassword());

        return new DataResponse(['token' => "$token"]);
    }
}
