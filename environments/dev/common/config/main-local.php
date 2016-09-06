<?php

return [
    'language' => 'ru',
    'components' => [
        'db'            => [
            'class'     => 'yii\db\Connection',
            'dsn'       => 'mysql:host=127.0.0.1;dbname=lexicon',
            'username'  => 'root',
            'password'  => '1234',
            'charset'   => 'utf8',
        ],
        'log'           => [
            'targets' => [
                [
                    'class'     => 'yii\log\FileTarget',
                    'levels'    => ['error', 'warning'],
                ],
            ],
        ],
    ],
];
