<?php

namespace App\Extensions\Permission;

use BenSampo\Enum\Enum;

final class Group extends Enum
{
    const GAME_MASTER = 1;
    const MANAGER = 2;
    const ADMINISTRATOR = 3;
    const MODERATOR = 4;
    const HELPER = 5;
    const YOUTUBER = 6;
    const MVP = 7;
    const VIP_PLUS = 8;
    const VIP = 9;
    const BUILDER = 10;
    const DEFAULT = 11;
    const GUEST = 12;
}
