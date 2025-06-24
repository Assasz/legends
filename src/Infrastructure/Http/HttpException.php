<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\Http;

final class HttpException extends \RuntimeException
{
    public function  __construct(
        string $message,
        private readonly string $title,
        private readonly int $statusCode,
    )
    {
        parent::__construct($message);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function serialize(): array
    {
        return [
            'title' => $this->title,
            'status' => $this->getStatusCode(),
            'detail' => $this->getMessage(),
        ];
    }
}
