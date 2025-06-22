<?php

declare(strict_types=1);

namespace Legends\Game\Application\Adventurer;

use Legends\Game\Domain\Adventurer\Adventurer;
use Legends\Game\Domain\Util\Id\Id;

interface AdventurerRepository
{
    public function getById(Id $id): Adventurer;

    public function persist(Adventurer $adventurer): void;
}
