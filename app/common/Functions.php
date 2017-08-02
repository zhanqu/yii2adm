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

}