<?php

return [
    [
        'class'         => \yii\rest\UrlRule::className(),
        'prefix'        => 'api/v1/frontend/json',
        'controller'    => [
            'word' => 'v1/word',
        ],
    ],
];
