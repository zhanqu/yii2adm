<?php
/**
 * 主题 Adminlte2
 */

namespace app\themes\adminlte2;
use yii\web\AssetBundle;

/**
 * @author zhanqu.im
 */
class ThemeAsset extends AssetBundle
{

    const  name = 'adminlte2';
    const  themeId = 'adminlte2';

    public $sourcePath = '@app/themes/'.self::themeId.'/assets';
    public $css = [
        'css/common.css'
    ];
    public $js = [
        'js/jquery.contextmenu.r2.js',
        'js/common.js'
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_END];
    public $depends = [
        'app\themes\adminlte2\AdminltePluginsAsset'
    ];
}
