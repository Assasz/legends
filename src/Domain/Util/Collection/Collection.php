<?php

declare(strict_types=1);

namespace Legends\Game\Domain\Util\Collection;

use function Lambdish\Phunctional\first;
use function Lambdish\Phunctional\all;
use function Lambdish\Phunctional\instance_of;

abstract class Collection implements \IteratorAggregate, \Countable
{
    protected array $items;

    final public function __construct(iterable $items = [])
    {
        $items = $items instanceof \Traversable ? iterator_to_array($items) : $items;
        $this->assertType($items);
        self::validate($items);
        $this->items = $items;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function isEmpty(): bool
    {
        return count($this->items) < 1;
    }

    public function makeSureNotEmpty(): void
    {
        if ($this->isEmpty()) {
            throw CollectionException::emptyCollection();
        }
    }

    public function filter(callable $filter): static
    {
        return new static(array_filter($this->items, $filter));
    }

    public function add(object $item): self
    {
        return new static(array_merge($this->items, [$item]));
    }

    public function addMany(iterable $items): self
    {
        $items = $items instanceof \Traversable ? iterator_to_array($items) : $items;

        return new static(array_merge($this->items, $items));
    }

    public function remove(object $item): self
    {
        return new static($this->filter(
            static fn(object $inventoryItem): bool => $inventoryItem !== $item,
        )->getItems());
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->items);
    }

    abstract protected function getType(): string;

    protected static function validate(array $items): void
    {

    }

    private function assertType(array $items): void
    {
        $type = $this->getType();

        if (!all(instance_of($type), $items)) {
            throw CollectionException::invalidType(get_class(first($items)), $type);
        }
    }
}
