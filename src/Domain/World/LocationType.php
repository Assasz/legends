<?php

declare(strict_types=1);

namespace Legends\Game\Domain\World;

enum LocationType: string
{
    case CITY = 'city';
    case JUNGLE = 'jungle';
    case DUNGEON = 'dungeon';
}
