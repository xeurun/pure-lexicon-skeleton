<?php

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'response'  => [
            'format'    => (preg_match('/^\/debug/',$_SERVER['REQUEST_URI']) || preg_match('/^\/gii/',$_SERVER['REQUEST_URI'])) ?
                yii\web\Response::FORMAT_HTML : yii\web\Response::FORMAT_JSON,
            'charset'   => 'UTF-8',
        ],
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
    ],
];
