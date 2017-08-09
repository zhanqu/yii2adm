<?php

$config = [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=192.168.33.30;dbname=yii2admin',
            'username' => 'misdev',
            'password' => 'misdev',
            'charset' => 'utf8',
            //'tablePrefix' => 'a_',
        ],
    ],
];

return $config;
