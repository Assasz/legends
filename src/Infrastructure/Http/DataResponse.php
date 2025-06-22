<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\Http;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class DataResponse extends JsonResponse
{
    public function __construct(array $data, int $statusCode = Response::HTTP_OK)
    {
        return parent::__construct(
            ['data' => $data],
            $statusCode,
            ['Content-Type' => 'application/vnd.api+json'],
        );
    }
}
