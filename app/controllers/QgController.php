<?php
/**
 * Created by PhpStorm.
 * User: yappy
 * Date: 17-9-15
 * Time: 上午10:54
 */

namespace app\controllers;

use app\common\redis\RedisInstance;
use yii;
use app\common\Controller;

class QgController extends Controller
{

    public function actionTest()
    {
        $client = RedisInstance::getInstance();
        for ($i = 0; $i < 1000; $i++) {
            $num = intval($client->get("nameNum"));
            $num = $num + 1;
            $client->setex("nameNum", $num);
            usleep(10000);
        }
    }

    public function actionRedisOrder()
    {

        $redis = RedisInstance::getInstance();
        $order_init = $redis->llen('order_init');
        $order_success = $redis->llen('order_success');
        echo '<pre>';
        var_dump( $order_init );
        echo '</pre>';
        exit;
        return $this->render('redis-order');
    }
    public function actionRedisOrderAdd()
    {
        $redis = Yii::$app->redis;
//保存用户订单信息，并未真正抢购成功，只是添加初始状态
        $redis->lpush('order_init',json_encode(['id'=>time().uniqid(),'buy_num'=>1,'sts'=>'0','msg'=>'抢购失败']));

//list pop操作，原子性，依次抛出
        $res = $redis->lpop('goods_store');
        if(!$res){
            $redis->lpush('error_list','goods_store sail not!!!'.$_SERVER["REMOTE_ADDR"]);
            echo 400;
            exit();
        }
//抢购成功，更改订单状态
        $order['sts']='1';
        $order['msg']='抢购成功';
//保存成功操作，并且可以在这针对数据库的减操作
        $redis->lpush('order_success',json_encode($order));
    }

    /**
     * 加锁
     */
    public function file_lock($filename){
        $fp_key = sha1($filename);
        $this->fps[$fp_key] = fopen($filename, 'w+');
        if($this->fps[$fp_key]){
            return flock($this->fps[$fp_key], LOCK_EX|LOCK_NB);
        }
        return false;
    }
    /**
     * 解锁
     */
    public function file_unlock($filename){
        $fp_key = sha1($filename);
        if($this->fps[$fp_key] ){
            flock($this->fps[$fp_key] , LOCK_UN);
            fclose($this->fps[$fp_key] );
        }
    }

    /**
     *  加锁
     */
    public function task_lock($taskid){
        $expire = 2;
        $lock_key ='task_get_reward_'.$this->uid.'_'.$taskid;
        $lock = $this->redis->setNX($lock_key , time());//设当前时间
        if($lock){
            $this->redis->expire($lock_key,  $expire); //如果没执行完 2s锁失效
        }
        if(!$lock){//如果获取锁失败 检查时间
            $time = $this->redis->get($lock_key);
            if(time() - $time  >=  $expire){//添加时间戳判断为了避免expire执行失败导致死锁 当然可以用redis自带的事务来保证
                $this->redis->rm($lock_key);
            }
            $lock =  $this->redis->setNX($lock_key , time());
            if($lock){
                $this->redis->expire($lock_key,  $expire); //如果没执行完 2s锁失效
            }
        }
        return $lock;
    }
    /**
     *  解锁
     */
    public function task_unlock($taskid){
        $this->set_redis();
        $lock_key = 'task_get_reward_'.$this->uid.'_'.$taskid;
        $this->redis->rm($lock_key);
    }
}