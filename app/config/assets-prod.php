<?php
/**
 * This file is generated by the "yii asset" command.
 * DO NOT MODIFY THIS FILE DIRECTLY.
 * @version 2017-08-01 03:03:46
 */
return [
    'allShared' => [
        'class' => 'yii\\web\\AssetBundle',
        'basePath' => '@webroot/assets',
        'baseUrl' => '@web/assets',
        'js' => [
            'all-shared-9912ead15d4d044d54383b1431a3b561.js',
        ],
        'css' => [
            'all-shared-9e072792f29725419dfdb2795440e4d6.css',
        ],
        'depends' => [],
        'sourcePath' => null,
    ],
    'allBackEnd' => [
        'class' => 'yii\\web\\AssetBundle',
        'basePath' => '@webroot/assets',
        'baseUrl' => '@web/assets',
        'js' => [
            'all-backend-97f9c942b862391d004c8bb1574ef61a.js',
        ],
        'css' => [
            'all-backend-668ea0fba48fc0d36837cc567752e448.css',
        ],
        'depends' => [],
        'sourcePath' => null,
    ],
    'allFrontEnd' => [
        'class' => 'yii\\web\\AssetBundle',
        'basePath' => '@webroot/assets',
        'baseUrl' => '@web/assets',
        'js' => [],
        'css' => [],
        'depends' => [],
        'sourcePath' => null,
    ],
    'yii\\web\\JqueryAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'allShared',
        ],
    ],
    'yii\\bootstrap\\BootstrapAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'allShared',
        ],
    ],
    'yii\\bootstrap\\BootstrapPluginAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'yii\\web\\JqueryAsset',
            'yii\\bootstrap\\BootstrapAsset',
            'allShared',
        ],
    ],
    'rmrevin\\yii\\fontawesome\\AssetBundle' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'allShared',
        ],
    ],
    'yii\\web\\YiiAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'yii\\web\\JqueryAsset',
            'allBackEnd',
        ],
    ],
    'yii\\jui\\JuiAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'yii\\web\\JqueryAsset',
            'allBackEnd',
        ],
    ],
    'app\\themes\\adminlte2\\AdminLteAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'rmrevin\\yii\\fontawesome\\AssetBundle',
            'yii\\web\\YiiAsset',
            'yii\\bootstrap\\BootstrapAsset',
            'yii\\bootstrap\\BootstrapPluginAsset',
            'allBackEnd',
        ],
    ],
    'app\\themes\\adminlte2\\ShowLoadingAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'yii\\web\\JqueryAsset',
            'allBackEnd',
        ],
    ],
    'app\\themes\\adminlte2\\AdminltePluginsAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'yii\\web\\YiiAsset',
            'yii\\bootstrap\\BootstrapAsset',
            'yii\\bootstrap\\BootstrapPluginAsset',
            'app\\themes\\adminlte2\\AdminLteAsset',
            'app\\themes\\adminlte2\\ShowLoadingAsset',
            'allBackEnd',
        ],
    ],
    'app\\plugins\\menu\\assets\\MenuAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'yii\\web\\YiiAsset',
            'yii\\jui\\JuiAsset',
            'allBackEnd',
        ],
    ],
    'app\\themes\\adminlte2\\ThemeAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'app\\themes\\adminlte2\\AdminltePluginsAsset',
            'allBackEnd',
        ],
    ],
    'nirvana\\showloading\\ShowLoadingAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'yii\\web\\JqueryAsset',
            'allBackEnd',
        ],
    ],
    'lo\\modules\\noty\\assets\\NotyAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'yii\\web\\JqueryAsset',
            'allBackEnd',
        ],
    ],
];