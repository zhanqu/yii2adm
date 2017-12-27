<?php
/**
 * 主题 Adminlte2
 */

namespace app\themes\adminlte2;
use yii\web\AssetBundle;

/**
 * @author chuan xiong <xiongchuan86@gmail.com>
 */
class ThemeAsset extends AssetBundle
{

    const  name = 'adminlte2';
    const  themeId = 'adminlte2';

    public $sourcePath = '@app/themes/'.self::themeId.'/assets';
    public $css = [
        'plugins/layer/skin/default/layer.css',
        'css/yii2adm.css'

    ];
    public $jsOptions = ['position' => \yii\web\View::POS_END];
    public $js = [
        'js/spark-md5.min.js',
        'js/jquery.contextmenu.r2.js',
        'plugins/layer/layer.js',
        'js/yii2adm.js',
        'js/blade-upload.js',
        'js/video.js',

    ];
    public $depends = [
        'app\themes\adminlte2\AdminltePluginsAsset'
    ];
    //定义按需加载JS方法，注意加载顺序在最后
/*    public static function addScript($view, $jsfile) {
        $view->registerJsFile($jsfile, [
            ThemeAsset::className(),
            "depends" => "app\\themes\\adminlte2\\ThemeAsset"
        ]);
    }
    //定义按需加载css方法，注意加载顺序在最后
    public static function addCss($view, $cssfile) {
        $view->registerCssFile($cssfile, [
            ThemeAsset::className(),
            "depends" => "@app\\themes\\adminlte2\\assets\\ThemeAsset"
        ]);
    }*/
}
