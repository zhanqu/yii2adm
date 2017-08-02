<?php

$config = [
    'components' => [
        'request' => [
            'enableCsrfValidation' => true,
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '123',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'messageConfig' => [
                'from'  => 'master@zhanqu.im',
            ],
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.exmail.qq.com',
                'username' => '',
                'password' => '',
                //'port' => '465',
                //'encryption' => 'tls',
            ],
        ],
    ],
];

return $config;
