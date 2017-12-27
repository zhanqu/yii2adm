<?php
/**
 * Configuration file for the "yii asset" console command.
 */

// In the console environment, some path aliases may not exist. Please define these:
// Yii::setAlias('@webroot', __DIR__ . '/../web');
// Yii::setAlias('@web', '/');
include 'app/config/bootstrap.php';

return [
    // Adjust command/callback for JavaScript files compressing:
    'jsCompressor' => 'java -jar tools/closure/closure-compiler-v20161201.jar --js {from} --js_output_file {to}',
    // Adjust command/callback for CSS files compressing:
    'cssCompressor' => 'java -jar tools/yui/yuicompressor-2.4.8.jar --type css {from} -o {to}',
    // Whether to delete asset source after compression:
    'deleteSource' => false,
    // The list of asset bundles to compress:
    // Asset bundle for compression output:
    'bundles' => [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
        'yii\jui\JuiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'rmrevin\yii\fontawesome\AssetBundle',
        'app\themes\upbond\UpbondPluginsAsset',  //theme
        'app\plugins\menu\assets\MenuAsset',
        'app\themes\upbond\ThemeAsset',  //theme
        'nirvana\showloading\ShowLoadingAsset',
        'app\themes\upbond\UpbondAsset',  //theme
        'app\themes\upbond\ShowLoadingAsset',  //theme
        'lo\modules\noty\assets\NotyAsset'
    ],
    'targets' => [
        'allShared' => [
            'class' => 'yii\web\AssetBundle',
            'basePath' => '@webroot/assets',
            'baseUrl' => '@web/assets',
            'js' => 'all-shared-{hash}.js',
            'css' => 'all-shared-{hash}.css',
            'depends' => [
                'yii\bootstrap\BootstrapAsset',
                'yii\bootstrap\BootstrapPluginAsset',
                'rmrevin\yii\fontawesome\AssetBundle',
                'yii\web\JqueryAsset',
            ],
        ],
        'allBackEnd' => [
            'class' => 'yii\web\AssetBundle',
            'basePath' => '@webroot/assets',
            'baseUrl' => '@web/assets',
            'js' => 'all-backend-{hash}.js',
            'css' => 'all-backend-{hash}.css',
            'depends' => [
                'yii\web\YiiAsset',
                'yii\jui\JuiAsset',
                'app\themes\upbond\UpbondPluginsAsset',
                'app\plugins\menu\assets\MenuAsset',
                'app\themes\upbond\ThemeAsset',
                'nirvana\showloading\ShowLoadingAsset',
                'app\themes\upbond\UpbondAsset',
                'app\themes\upbond\ShowLoadingAsset',
                'lo\modules\noty\assets\NotyAsset'
            ],
        ],
        'allFrontEnd' => [
            'class' => 'yii\web\AssetBundle',
            'basePath' => '@webroot/assets',
            'baseUrl' => '@web/assets',
            'js' => 'all-frontend-{hash}.js',
            'css' => 'all-frontend-{hash}.css',
            'depends' => [

            ],
        ],
    ],
    // Asset manager configuration:
    'assetManager' => [
        'basePath' => '@webroot/static/assets',
        'baseUrl' => '@web/static/assets',
    ],
];