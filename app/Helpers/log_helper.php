<?php

function save_log($activity)
{
    $db = \Config\Database::connect();
    $request = service('request');

    $db->table('logs')->insert([
        'id_user'  => session('id_user') ?? null,
        'activity' => $activity,
        'ip'       => $request->getIPAddress(),
        'menu'     => $request->getUri()->getPath(),
    ]);
}