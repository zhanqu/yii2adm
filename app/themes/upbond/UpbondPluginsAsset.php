<?php
/**
 * Created by PhpStorm.
 * User: xiongchuan
 * Date: 2017/1/1
 * Time: 下午12:10
 */
namespace app\themes\upbond;

use yii\web\AssetBundle;

class UpbondPluginsAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins';
    public $js = [
        'fastclick/fastclick.js',
    ];
    public $css = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'app\themes\upbond\AdminLteAsset',
        'app\themes\upbond\ShowLoadingAsset',
    ];
}