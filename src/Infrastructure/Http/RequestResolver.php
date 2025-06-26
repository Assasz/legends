<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\Http;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\SerializerInterface;

final readonly class RequestResolver implements ValueResolverInterface
{
    public function __construct(
        private SerializerInterface $serializer,
    ) {
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $argumentType = $argument->getType();
        if (class_exists($argumentType) === false) {
            throw new \RuntimeException("Cannot resolve argument of non existent class `$argumentType`");
        }

        return [$this->serializer->deserialize($request->getContent(), $argumentType, 'json')];
    }
}
