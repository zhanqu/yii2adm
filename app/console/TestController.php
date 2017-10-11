<?php
/**
 * Created by PhpStorm.
 * User: yappy
 * Date: 17-7-21
 * Time: 上午10:14
 */

namespace app\console;


use app\common\Functions;
use app\common\RedisInstance;
use app\common\RedisLock;
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

    public function actionTest()
    {
        $client = RedisInstance::getInstance();
        for ($i = 0; $i < 1000; $i++) {
            $client->incr("name");
            $client->expire("name", 10800);
            usleep(10000);
        }
    }
    public function actionRedis()
    {
        $client = RedisInstance::getInstance();
        $start_time = microtime(true);
        $lock = new RedisLock($client);
        $key = "redisLock";
        for ($i = 0; $i < 10; $i++) {
            $newExpire = $lock->getLock($key);
            $num = $client->get($key);
            $num++;
            $client->set($key, $num);
            $lock->releaseLock($key, $newExpire);
        }
        $end_time = microtime(true);

        echo "花费时间 ： ". ($end_time - $start_time) . "\n";

    }
}