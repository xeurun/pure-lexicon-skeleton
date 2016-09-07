<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id'                    => 'app-frontend',
    'basePath'              => dirname(__DIR__),
    'controllerNamespace'   => 'common\api\frontend\controllers',
    'bootstrap'             => ['log'],
    'modules'               => [],
    'components'            => [
        'urlManager'    => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'showScriptName' => false,
            'rules' => array_merge(
                require(__DIR__ . '/../../common/config/rules/v1/frontend.php')
            ),
        ],
    ],
    'params' => $params,
];
