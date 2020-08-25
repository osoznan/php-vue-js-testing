<?php

use osoznan\patri\Top;
use osoznan\patri\Db;

return [
    'components' => [
        'db' => array_merge([
            'class' => Db::class,
            'on' => [
                Db::EVENT_AFTER_SQL => function($e) {
                    Top::$app->get('log')->add($e->data['sql']);
                }
            ]
        ], require(__DIR__ . '/db.php')),
        'mailer' => [
            'class' => \app\core\components\MailSender::class,
            'on' => [
                'error' => function () {
                    echo 'error';
                }
            ]
        ],
        'log' => [
            'class' => \app\core\components\Logger::class,
            'filename' => __DIR__ . '/../temp/log.txt'
        ]
    ],
    'baseUrl' => IS_RELEASE ? 'https://somesite.com' : null,
    'basePath' => __DIR__ . '/../',
    'apps' => [
        'site' => [
            'class' => \app\site\App::class
        ]
    ],

    'urlMap' => [],

    'email' => 'yuoanswami@gmail.com',
];
