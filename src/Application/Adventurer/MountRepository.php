<?php

declare(strict_types=1);

namespace Legends\Game\Application\Adventurer;

use Legends\Game\Domain\Adventurer\Mount;
use Legends\Game\Domain\Util\Id\Id;

interface MountRepository
{
    public function getById(Id $id): Mount;
}
