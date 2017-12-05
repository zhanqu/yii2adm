<?php
namespace app\common;

use yii;
class Functions
{
    //for menu/nav items
    static function formatItem($v){
        $item=[];
        if($v && is_array($v)){
            $item['url']  = isset($v['value']['url']) ? $v['value']['url'] : '#';
            $item['icon']  = isset($v['value']['icon']) && !empty($v['value']['icon'])? $v['value']['icon'] : 'fa  fa-angle-right';
            $item['label']= $v['cfg_comment'];
            if(isset($v['active']))$item['active'] = true;
        }
        return $item;
    }

    static function genMenuItems($menu_key)
    {
        $items = [];
        if( isset(Yii::$app->params[$menu_key]) && Yii::$app->params[$menu_key] && is_array(Yii::$app->params[$menu_key])){

            foreach (Yii::$app->params[$menu_key] as $k=>$v){
                if($v['cfg_pid'] == 0){
                    $items[$v['id']] = static::formatItem($v);
                }else{
                    continue;
                }
            }
            foreach (Yii::$app->params[$menu_key] as $k=>$v){
                if($v['cfg_pid']>0){
                    if(isset($items[$v['cfg_pid']])){
                        if(!isset($items[$v['cfg_pid']]['items'])){
                            $items[$v['cfg_pid']]['items']   = [];
                            $items[$v['cfg_pid']]['items'][$v['id']] = static::formatItem($v);
                        }else{
                            $items[$v['cfg_pid']]['items'][$v['id']] = static::formatItem($v);
                        }
                    }else{
                        $items[$v['id']] = static::formatItem($v); //cfg_pid 不正确的情况
                    }
                }
            }

        }
        return $items;
    }
    /*
     * 获取随机红包
     * min<k<max
     * min(n-1) <= money - k <= (n-1)max
     * k <= money-(n-1)min
     * k >= money-(n-1)max
     */
    public static function getRedPackage($money, $num, $min, $max)
    {
        $data = array();
        if ($min * $num > $money) {
            return array();
        }
        if($max*$num < $money){
            return array();
        }
        while ($num >= 1) {
            $num--;
            $kmix = max($min, $money - $num * $max);
            $kmax = min($max, $money - $num * $min);
            $kAvg = $money / ($num + 1);
            //获取最大值和最小值的距离之间的最小值
            $kDis = min($kAvg - $kmix, $kmax - $kAvg);
            //获取0到1之间的随机数与距离最小值相乘得出浮动区间，这使得浮动区间不会超出范围
            $r = ((float)(rand(1, 10000) / 10000) - 0.5) * $kDis * 2;
            $k = round($kAvg + $r);
            $money -= $k;
            $data[] = $k;
        }
        return $data;
    }


    public static function base64ToImg($base64_image_content, $path)
    {
        $filePath = '';
        //$root = $_SERVER['DOCUMENT_ROOT'].'/'.$path;
        $root = Yii::getAlias('@webroot') . '/' . $path;
        $folder = date('Ym',time()) . "/";

        if (!is_dir($root . $folder)) {
            if (!mkdir($root . $folder, 0777, true)) {
                return ['status' => 0, 'message' => '创建目录失败'];
                //die('创建目录失败...');
            }
        }
        $pre = rand(999, 9999) . time();
        //保存base64字符串为图片
        //匹配出图片的格式
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)) {
            $type = $result[2];
            $newName = $pre . ".{$type}";
            $new_file = $root . $folder . $newName;
            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))) {
                return $path . $folder . $newName;
            }
        }
        return $filePath;
    }
}