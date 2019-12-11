<?php

return [
    'adauthtrait' => [
        'server' => '193.219.163.250',
        'port' => 389,
        'socket_timeout' => 4,
        'domain' => '@kmu.lt',
        'dn' => 'dc=KMU,dc=LT',
        'local_bypass' => [
            'root',
        ],
        'options' => [
            'referrals' => 0,
            'protocol_version' => 3,
            'timeout' => 4,
        ],
    ],
];
