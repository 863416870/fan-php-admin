<?php
/**
 * Log日志类
 */
namespace app\common\tools;
use think\facade\Request;

class Log {
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

    /**
     * 通用日志记录
     * @param $content
     * @param string $subDir
     * @return bool
     */

    public static function logs($content, $subDir = ''){
        $subDir = trim($subDir, '/\\');
        if (empty($content)) return false;
        static $arrConfig = array();
        if (empty($arrConfig)){
            $arrPath  = array(Request::module(), Request::controller(), Request::controller());
            $arrConfig['root_path'] = './Runtime/Logs/';
            $arrConfig['sub_dir']   = implode('/', $arrPath);
            $arrConfig['file_name'] = '/' . date('Ymd') . '.log';
            $arrConfig['client_ip'] = "127.0.0.1";
            $arrConfig['logs_no']   = date('ymdHis') . microtime() * 1000000;
        }

        $filepath = $arrConfig['root_path'];
        if ($subDir){
            $filepath .= $subDir ;
        } else {
            $filepath .= $arrConfig['sub_dir'] ;
        }

        if (!file_exists($filepath)){
            mkdir($filepath, 0777, TRUE);
        }

        $filepath .= $arrConfig['file_name'];

        $header = sprintf("\r\n\r\n[%s][%s][%s] ", date('Y-m-d H:i:s'), $arrConfig['client_ip'],$arrConfig['logs_no']);
        @file_put_contents($filepath, $header . $content, FILE_APPEND);

        return $arrConfig['logs_no'] ;
    }


    //通用写入
    private static function write($content, $type = "app"){
        $filePath = realpath(APPLICATION_PATH."/../log");
        $fileName = $type . ".log." . date("Ymd");
        $fileLog  = $filePath . "/" . $fileName;

        if(file_exists($fileLog)){
            file_put_contents($fileLog, $content, FILE_APPEND);
        }else{
            file_put_contents($fileLog, $content);
        }
    }

    private static function commonHeader($debugInfo, $userFlag = true){
        $logId = self::getLogId();
        $userId = $userFlag ? self::getUserId() : 0;
        $url = self::getUrl();
        $commonHeader = "[" . date("Y-m-d H:i:s") . "] [" . $debugInfo[0]['file'] . ":" . $debugInfo[0]['line'] . "] ";
        $commonHeader .= " logid[$logId] ";
        $commonHeader .= " userid[$userId] ";
        $commonHeader .= " url[$url] ";

        return $commonHeader;
    }

    private static function commonFooter($debugInfo, $paramsFlag = true){
        $commonFooter = "\n"."[" . date("H:i:s") . "]Stack trace:"."\n";
        foreach($debugInfo as $key => $val){
            if($key == 0){
                continue;
            }
            $args = count($val['args']) > 0 && $paramsFlag ? "$" . "args=" . str_replace('\n', '', var_export($val['args'], true)) : "";
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
    public static function trace($mixed, $userFlag = true){
        $debugInfo = debug_backtrace();

        $commonHeader = self::commonHeader($debugInfo, $userFlag);

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
    public static function error($mixed, $userFlag = true){
        $debugInfo = debug_backtrace();

        $commonHeader = self::commonHeader($debugInfo, $userFlag);
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
