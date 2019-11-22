<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/22
 * Time: 14:42
 */
namespace app\api\controller\redis;

use app\lib\redis\Base as RedisBase;
use app\common\tools\Log;

class Subscribe
{
    public function sub()
    {
        Log::error(time()."__超时任务__:");
        $redis = new RedisBase();
        $redis->setOption();

        $redis->psubscribe(array('__keyevent@0__:expired'), function ($redis, $pattern, $chan, $msg) {
            //逻辑处理
            Log::error('[1]--过期事件的订阅 ' . json_encode($msg));
            Log::error(json_encode($redis));
            Log::error(json_encode($pattern));
            Log::error(json_encode($chan));
            Log::error($msg);
        });
    }
}