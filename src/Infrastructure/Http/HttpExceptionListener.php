<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\Http;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

final readonly class HttpExceptionListener
{
    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof HttpException === false) {
            return;
        }

        $response = new JsonResponse(
            ['errors' => [$exception->serialize()]],
            $exception->getStatusCode(),
            ['Content-Type' => 'application/problem+json'],
        );

        $event->setResponse($response);
    }
}
