<?php
/**
 * Created by PhpStorm.
 * User: yappy
 * Date: 17-7-21
 * Time: 上午10:14
 */

namespace app\console;


use app\common\Functions;
use yii\console\Controller;

class TestController extends Controller
{
    public function actionIndex()
    {
        $data=Functions::getRedPackage(10,5,0.01,5.00);
        for ($i = 0; $i <= count($data)-1; $i++) {
            echo  $data[$i];


        }
    }
}