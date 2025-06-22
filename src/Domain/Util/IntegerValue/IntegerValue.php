<?php

declare(strict_types=1);

namespace Legends\Game\Domain\Util\IntegerValue;

class IntegerValue implements \Stringable
{
    protected int $value;

    final public function __construct(int $value)
    {
        self::validate($value);
        $this->value = $value;
    }

    public function get(): int
    {
        return $this->value;
    }

    public function equals(self $value): bool
    {
        return $this->value === $value->get();
    }

    public function isLowerThan(self $value): bool
    {
        return $this->value < $value->get();
    }

    public function isGreaterThan(self $value): bool
    {
        return $this->value > $value->get();
    }

    public function isGreaterThanOrEqual(self $value): bool
    {
        return $this->value >= $value->get();
    }

    public function diff(self $value): static
    {
        return new static(abs($this->value - $value->get()));
    }

    public function increment(): static
    {
        return new static($this->value += 1);
    }

    public function decrement(): static
    {
        return new static($this->value -= 1);
    }

    public function increaseBy(self $value): static
    {
        return new static($this->value += $value->get());
    }

    public function decreaseBy(self $value): static
    {
        return new static($this->value -= $value->get());
    }

    public function replaceWith(self $value): static
    {
        return new static($value->get());
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }

    protected static function validate(int $value): void
    {
        if ($value < 0) {
            throw IntegerValueException::onlyPositive();
        }
    }
}
