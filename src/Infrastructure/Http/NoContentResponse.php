<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\Http;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class NoContentResponse extends JsonResponse
{
    public function __construct()
    {
        parent::__construct(null, Response::HTTP_NO_CONTENT);
    }
}
