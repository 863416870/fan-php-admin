<?php
/**
 * 异常常量定义
 * Created by PhpStorm
 * User: 范国洁
 * Date: 2019/8/31
 * Time: 15:57
 */

namespace app\common\util;

class ExceptionUtil
{
    //定义常量
    const CODE = "code";
    const MESSAGE = "msg";
    const ERROR_CODE = "error_code";

    public static $param = [];


    /**
     * 参数数据异常
     * @param string $message 异常提示信息
     * @param int $errorCode  异常状态码
     * @param int $code       http状态码
     * @return array
     */
    public static function ParameterExceptionMap(
        $message="参数错误",
        $errorCode=99999,
        $code=400
    ){
        return self::setParam($message,$errorCode,$code);
    }

    /**
     * 反射解析数据异常
     * @param string $message 异常提示信息
     * @param int $errorCode  异常状态码
     * @param int $code       http状态码
     * @return array
     */
    public static function ParseExceptionMap(
                        $message="解析数据时出现错误，请检查类·方法注释抒写方式",
                        $errorCode=66667,
                        $code=400
    ){
       return self::setParam($message,$errorCode,$code);
    }


    /**
     * 反射的对象/方法注释错误
     * @param string $message 异常提示信息
     * @param int $errorCode  异常状态码
     * @param int $code       http状态码
     * @return array
     */
    public static function ReflexExceptionMap(
                        $message="反射的对象/方法注释错误",
                        $errorCode=66666,
                        $code=400
    ){
        return self::setParam($message,$errorCode,$code);
    }


    /**
     *日志信息
     * @param string $message 异常提示信息
     * @param int $errorCode  异常状态码
     * @param int $code       http状态码
     * @return array
     */
    public static function LoggerExceptionMap(
                        $message="日志信息不能为空",
                        $errorCode=40001,
                        $code=400){
        return self::setParam($message,$errorCode,$code);
    }

    /**
     * 公共赋值方法
     * @param string $message 异常提示信息
     * @param int $errorCode  异常状态码
     * @param int $code       http状态码
     * @return array
     */
    public static function setParam($message,$errorCode,$code){
        self::$param[self::CODE] = $code;
        self::$param[self::MESSAGE] = $message;
        self::$param[self::ERROR_CODE] = $errorCode;
        return self::$param;
    }

}