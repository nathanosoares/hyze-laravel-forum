<?php


return [
    /*
    |--------------------------------------------------------------------------
    | Super Admins
    |--------------------------------------------------------------------------
    |
    | ID dos usuários que possuem permissões totais no sistema
    |
    */
    'super_admins' => explode(',', env('SUPER_ADMINS', '')),
    'thread_posts_per_page' => 10
];