<?php
/**
 * redis 基础方法文件
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/9/9
 * Time: 14:42
 */
namespace app\common\tools\redis;

use app\common\tools\Log;

class RedisBase
{
    private $redis;

    public function __construct($config = 'default')
    {

        try{
            $this->redis = RedisConnect::getInstance();
        }catch (\Exception $e){
            Log::error("[Redis Connect Failed] errmsg is [". $e->getMessage() ."]");
        }
        $this->setex("fan",10,"aa");
        if($this->redis == false){
            Log::error("[Redis Connect Failed] config is [" . $config . "]");
        }
    }

    public function __call($method, $params)
    {
        try{
            if(empty($this->redis)){
                return false;
            }else{
                return call_user_func_array(array($this->redis,$method),$params);
            }
        }catch (\Exception $e){
            Log::error("[Redis Operation Failed] errmsg is [". $e->getMessage() ."]");
        }
        return false;
    }


    public function setex($key, $time, $val)
    {
        return $this->redis->setex($key, $time, $val);
    }

    public function set($key, $val)
    {
        return $this->redis->set($key, $val);
    }

    public function get($key)
    {
        return $this->redis->get($key);
    }

    public function expire($key = null, $time = 0)
    {
        return $this->redis->expire($key, $time);
    }

    public function psubscribe($patterns = array(), $callback)
    {
        $this->redis->psubscribe($patterns, $callback);
    }

    public function setOption()
    {
        //-1均表示不超时，也可以将超时设置为自己希望的时间， 前面复现时就是设为为0.01ms
        $this->redis->setOption(\Redis::OPT_READ_TIMEOUT, -1);
    }
}