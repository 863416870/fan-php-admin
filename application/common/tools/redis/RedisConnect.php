<?php
/**
 * Redis配置文件基类
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/9/9
 * Time: 14:41
 */
namespace app\common\tools\redis;

use app\common\tools\Log;
class RedisConnect
{
    //单例
    //类静态变量全局保存
    private static $instance = array();

    private function __construct()
    {
    }

    /**
     * getInstance
     * 获取redis 实例
     * @param string $section
     * @return void
     */
    public static function getInstance($section = 'default')
    {
        if(isset(self::$instance[$section])){
            return self::$instance;
        }

        $conn = self::getConnect($section);

        if($conn === false){
            return false;
        }
        self::$instance[$section] = $conn;
        return self::$instance[$section];
    }

    /**
     * getConnect 连接redis
     */
    public static function getConnect($section)
    {
        $configArr = self::getConfig($section);
        if(empty($configArr)){
            return false;
        }
        $redis = new \Redis();
        $retryDelay = isset($configArr['connect_retry_delay']) ? $configArr['connect_retry_delay']: 100;
        $timeout = isset($configArr['connect_timeout']) ? $configArr['connect_timeout'] : 1;
        $password =isset($configArr['password']) ? $configArr['password'] : '';

        $result = $redis->connect($configArr['host'],$configArr['port'],$timeout,null,$retryDelay);
        Log::error("[Redis Connect] errmsg is [". $result ."]");
        if($result){
            if($password){
                $redis->auth($password);
            }
            return $redis;
        }
        return false;
    }


    /**
     *
     * getConfig 获取redis配置信息
     */
    public static function getConfig($section)
    {
        $conMap = array(
            'default' => array(
                'host'                => '127.0.0.1',
                'port'                => '6379',
                'connect_timeout'     => '1.5',
                'connect_retry_delay' => '100',
                'connect_retry_times' => 3,
                'password'            =>''
            )
        );
        if(!isset($conMap[$section])){
            return array();
        }
        return $conMap[$section];
    }
}