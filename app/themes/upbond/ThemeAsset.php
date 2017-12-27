<?php
/**
 * 主题 upbond
 */

namespace app\themes\upbond;
use yii\web\AssetBundle;

/**
 * @author zhanqu.im
 */
class ThemeAsset extends AssetBundle
{

    const  name = 'upbond';
    const  themeId = 'upbond';

    public $sourcePath = '@app/themes/'.self::themeId.'/assets';
    public $css = [

    ];
    public $js = [

    ];
    public $jsOptions = ['position' => \yii\web\View::POS_END];
    public $depends = [
        'app\themes\upbond\AdminltePluginsAsset'
    ];
}
