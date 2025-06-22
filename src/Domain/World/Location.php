<?php

declare(strict_types=1);

namespace Legends\Game\Domain\World;

use Legends\Game\Domain\Util\Id\Id;
use Legends\Game\Domain\Util\Id\IdCollection;

final readonly class Location implements \Stringable
{
    public function __construct(
        private Id $id,
        private string $name,
        private LocationType $type,
        private IdCollection $entrypoints,
    ) {
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getType(): LocationType
    {
        return $this->type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEntrypoints(): IdCollection
    {
        return $this->entrypoints;
    }

    public function __toString(): string
    {
        return $this->name;
    }

//    public function getMerchants(): array; //@todo
//
//    public function getArena(): object; //@todo
//
//    public function getQuestboard(): object; //@todo
}
