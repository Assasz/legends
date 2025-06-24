<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\Exception;

use Legends\Game\Domain\Util\DomainException;
use Legends\Game\Infrastructure\Http\HttpException;
use Legends\Game\Infrastructure\Persistence\RepositoryException;
use Legends\Game\Infrastructure\User\UserException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

final readonly class ExceptionListener
{
    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $event->setThrowable(match (true) {
            $exception instanceof UserException => new HttpException(
                $exception->getMessage(),
                'Unauthorized',
                Response::HTTP_UNAUTHORIZED,
            ),
            $exception instanceof RepositoryException => new HttpException(
                $exception->getMessage(),
                'Not Found',
                Response::HTTP_NOT_FOUND,
            ),
            $exception instanceof DomainException => new HttpException(
                $exception->getMessage(),
                $exception->getType(),
                Response::HTTP_UNPROCESSABLE_ENTITY,
            ),
            default => new HttpException(
                $exception->getMessage(),
                'Internal Server Error',
                Response::HTTP_INTERNAL_SERVER_ERROR,
            ),
        });
    }
}
