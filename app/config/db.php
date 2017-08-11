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
        'mongodb' => [
            'class' => 'yii\mongodb\Connection',
            # 有账户的配置
            //'dsn' => 'mongodb://username:password@localhost:27017/datebase',
            # 无账户的配置
            'dsn' => 'mongodb://127.0.0.1:27017/yii2adm',
            # 复制集
            //'dsn' => 'mongodb://10.10.10.252:10001/erp,mongodb://10.10.10.252:10002/erp,mongodb://10.10.10.252:10004/erp?replicaSet=terry&readPreference=primaryPreferred',
        ],
    ],
];

return $config;
