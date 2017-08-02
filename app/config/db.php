<?php

$config = [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=yii2adm',
            'username' => 'misdev',
            'password' => 'misdev',
            'charset' => 'utf8',
            'tablePrefix' => 'a_',
        ],
    ],
];

return $config;
