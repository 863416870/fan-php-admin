<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/22
 * Time: 14:42
 */
namespace app\api\controller\redis;

use app\lib\redis\Base as RedisBase;
use think\facade\Log;

//use app\common\tools\Log;


class Subscribe
{
    public function sub()
    {
        Log::write(time()."__超时任务__:");

        $redis = new RedisBase();
        $redis->setOption();

        $redis->psubscribe(array('__keyevent@0__:expired'), function ($redis, $pattern, $chan, $msg) {
            //逻辑处理
            Log::write('[1]--过期事件的订阅 ' . json_encode($msg));
            Log::write(json_encode($redis));
            Log::write(json_encode($pattern));
            Log::write(json_encode($chan));
            Log::write($msg);
        });
    }
}