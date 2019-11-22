<?php
/**
 * redis 基类
 * User: fan
 * Date: 2019/11/22
 * Time: 12:35
 */

namespace app\lib\redis;
use think\facade\Log;

class Base
{
    private $redis;

    public function __construct($config = 'default') {
        try {
            $this->redis = ConnMgr::getInstance($config);
        } catch (\Exception $ex) {
            Log::write("[Redis Connect Failed] errmsg is [". $ex->getMessage() ."]");
        }

        if($this->redis == false){
            Log::write("[Redis Connect Failed] config is [" . $config . "]");
        }
    }

    public function __call($method, $params) {
        try{
            if (empty($this->redis)) {
                return false;
            } else {
                return call_user_func_array(array($this->redis, $method), $params);
            }
        } catch (\Exception $ex) {
            Log::write("[Redis Operation Failed] errmsg is [". $ex->getMessage() ."]");
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
        $this->redis->setOption(\Redis::OPT_READ_TIMEOUT, -1);
    }
}