<?php
/**
 * Created by PhpStorm.
 * User: yappy
 * Date: 17-12-21
 * Time: 下午4:42
 */

namespace app\themes\upbond;
use yii\base\Exception;
use dmstr\web\AdminLteAsset as BaseAdminLteAsset;
/**
 * AdminLte AssetBundle
 * @since 0.1
 */
class UpbondAsset extends BaseAdminLteAsset
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/dist';
    public $css = [
        'css/AdminLTE.min.css',
        'css/skins/_all-skins.min.css'
    ];
    public $js = [
        'js/app.min.js'
    ];
    public $depends = [
        'rmrevin\yii\fontawesome\AssetBundle',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
    /**
     * @var string|bool Choose skin color, eg. `'skin-blue'` or set `false` to disable skin loading
     * @see https://almsaeedstudio.com/themes/AdminLTE/documentation/index.html#layout
     */
    public $skin = null;
    /**
     * @inheritdoc
     */
    public function init()
    {
        // Append skin color file if specified
        parent::init();
    }
}