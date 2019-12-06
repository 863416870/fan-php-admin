<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/9/5
 * Time: 17:19
 */

namespace app\common\tools;
use think\facade\Log as LLOG;

class Log
{
    public static function getLogId(){
        if(defined('LOG_ID')){
            return LOG_ID;
        }

        if(isset($_REQUEST['logid']) && intval($_REQUEST['logid']) !== 0){
            define('LOG_ID', intval($_REQUEST['logid']));
        }else{
            $arr = gettimeofday();
            $logId = ((($arr['sec']*100000 + $arr['usec']/10) & 0x7FFFFFFF) | 0x80000000);
            define('LOG_ID', $logId);
        }

        return LOG_ID;

    }

    public static function getUrl(){
        if(PHP_SAPI == "cli"){
            return "";
        }
        $url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER["REQUEST_URI"];
        return $url;
    }

    //通用写入
    private static function write($content, $type = "app"){
        $filePath = realpath(env('app_path')."/../log");
        $fileName = $type . ".log." . date("Ymd");
        $fileLog  = $filePath . "/" . $fileName;

        if(file_exists($fileLog)){
            file_put_contents($fileLog, $content, FILE_APPEND);
        }else{
            file_put_contents($fileLog, $content);
        }
    }

    private static function commonHeader($debugInfo, $shopFlag = true, $userFlag = true){
        $logId = self::getLogId();
        $url = self::getUrl();
        $commonHeader = "[" . date("Y-m-d H:i:s") . "] [" . $debugInfo[0]['file'] . ":" . $debugInfo[0]['line'] . "] ";
        $commonHeader .= " logid[$logId] ";
        $commonHeader .= " url[$url] ";

        return $commonHeader;
    }

    private static function commonFooter($debugInfo, $paramsFlag = true){
        $commonFooter = "\n"."[" . date("H:i:s") . "]Stack trace:"."\n";
        return json_encode($debugInfo);
        foreach($debugInfo as $key => $val){
            if($key == 0){
                continue;
            }
            $args = count($val['args']) > 0 && $paramsFlag ? "$" . "args=" . str_replace('\n', '', var_export($val['args'], true)) : "";
            LLOG::write($args);
            $commonFooter .= "#$key ". (isset($val['file']) ? $val['file'] : "[internal function]") . "(" . (isset($val['line']) ? $val['line'] : "") . "):" . $val['class'] . $val['type'] . $val['function'] . "(" . $args . ")" . "\n";
        }


        return $commonFooter;
    }


    //debug
    public static function debug($mixed, $paramsFlag = true){
        $debugInfo = debug_backtrace();

        $commonHeader = self::commonHeader($debugInfo);
        $commonFooter = self::commonFooter($debugInfo, $paramsFlag);
        $content = $commonHeader . (var_export($mixed, true)) . $commonFooter . "\n";

        self::write($content, "debug");
    }

    //trace
    public static function trace($mixed, $shopFlag = true, $userFlag = true){
        $debugInfo = debug_backtrace();

        $commonHeader = self::commonHeader($debugInfo, $shopFlag, $userFlag);

        $commonFooter = self::commonFooter($debugInfo, $paramsFlag = false);
        $content = $commonHeader . (var_export($mixed, true)) .  $commonFooter . "\n" ."\n";

        self::write($content, "trace");
    }

    //cront
    public static function cront($mixed, $paramsFlag = false){
        $debugInfo = debug_backtrace();

        $commonHeader = self::commonHeader($debugInfo);
        $commonFooter = "";

        $content = $commonHeader . (var_export($mixed, true)) .  $commonFooter . "\n" ."\n";

        self::write($content, "cront");
    }

    //error
    public static function error($mixed, $shopFlag = true, $userFlag = true){
        $debugInfo = debug_backtrace();

        $commonHeader = self::commonHeader($debugInfo, $shopFlag, $userFlag);
        $commonFooter = "";

        $content = $commonHeader . (var_export($mixed, true)) .  $commonFooter . "\n";

        self::write($content, "error");
    }

    //req
    public static function req($mixed, $paramsFlag = false){
        $debugInfo = debug_backtrace();

        $commonHeader = self::commonHeader($debugInfo);

        $commonFooter = self::commonFooter($debugInfo, $paramsFlag);
        $content = $commonHeader . (var_export($mixed, true)) .  $commonFooter . "\n" ."\n";

        self::write($content, "req");
    }


    public static function printr($params){
        echo  "<pre>";
        print_r($params);
        echo  "</pre>";
    }

    public static function sqlQuery($sql) {
        self::write($sql . "\n\n", "db");
    }
}