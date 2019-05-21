<?php

namespace App\Extensions\Permission;

use BenSampo\Enum\Enum;

final class Group extends Enum
{
    const GAME_MASTER = [
        'display_name' => 'Hyze',
        'color' => '#FFAA00',
        'priority' => 11
    ];

    const MANAGER = [
        'display_name' => 'Gerente',
        'color' => '#AA0000',
        'priority' => 10
    ];

    const ADMINISTRATOR = [
        'display_name' => 'Administrador',
        'color' => '#FF5555',
        'priority' => 9
    ];

    const MODERATOR = [
        'display_name' => 'Moderador',
        'color' => '#55FF55',
        'priority' => 8
    ];

    const HELPER = [
        'display_name' => 'Ajudante',
        'color' => '#FFFF55',
        'priority' => 7
    ];

    const YOUTUBER = [
        'display_name' => 'Youtuber',
        'color' => '#FF5555',
        'priority' => 6
    ];

    const MVP = [
        'display_name' => 'MVP',
        'color' => '#55FFFF',
        'priority' => 5
    ];

    const VIP_PLUS = [
        'display_name' => 'VIP+',
        'color' => '#FFAA00',
        'priority' => 4
    ];

    const VIP = [
        'display_name' => 'VIP',
        'color' => '#FFAA00',
        'priority' => 3
    ];

    const BUILDER = [
        'display_name' => 'Construtor',
        'color' => '#55FF55',
        'priority' => 2
    ];

    const DEFAULT = [
        'display_name' => 'Membro',
        'color' => '#AAAAAA',
        'priority' => 1
    ];
}
