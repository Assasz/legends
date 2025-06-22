<?php

declare(strict_types=1);

namespace Legends\Game\Application\World;

use Legends\Game\Domain\Util\Id\Id;
use Legends\Game\Domain\World\Location;

interface LocationRepository
{
    public function getById(Id $id): Location;
}
