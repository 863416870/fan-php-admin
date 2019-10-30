<?php
/**
 * 常量定义
 * Created by PhpStorm
 * User: 范国洁
 * Date: 2019/8/31
 * Time: 15:55
 */

namespace app\common\util;


class ConstUtil
{
    //通用状态值
    const COMMON_STATUS_VALID = 1;
    const COMMON_STATUS_DELETE = 2;

    public static $COMMON_STATUS_MAP = array(
        self::COMMON_STATUS_VALID => "正常",
        self::COMMON_STATUS_DELETE => "删除",
    );

    //阿里云OSS上传点
    public static $OSS_MAP = array(
        'oss-cn-hangzhou.aliyuncs.com'    => '华东 1 杭州',
        'oss-cn-shanghai.aliyuncs.com'    => '华东 2 上海',
        'oss-cn-qingdao.aliyuncs.com'     => '华北 1 青岛',
        'oss-cn-beijing.aliyuncs.com'     => '华北 2 北京',
        'oss-cn-zhangjiakou.aliyuncs.com' => '华北 3 张家口',
        'oss-cn-huhehaote.aliyuncs.com'   => '华北 5 呼和浩特',
        'oss-cn-shenzhen.aliyuncs.com'    => '华南 1 深圳',
        'oss-cn-hongkong.aliyuncs.com'    => '香港 1',
        'oss-us-west-1.aliyuncs.com'      => '美国西部 1 硅谷',
        'oss-us-east-1.aliyuncs.com'      => '美国东部 1 弗吉尼亚',
        'oss-ap-southeast-1.aliyuncs.com' => '亚太东南 1 新加坡',
        'oss-ap-southeast-2.aliyuncs.com' => '亚太东南 2 悉尼',
        'oss-ap-southeast-3.aliyuncs.com' => '亚太东南 3 吉隆坡',
        'oss-ap-southeast-5.aliyuncs.com' => '亚太东南 5 雅加达',
        'oss-ap-northeast-1.aliyuncs.com' => '亚太东北 1 日本',
        'oss-ap-south-1.aliyuncs.com'     => '亚太南部 1 孟买',
        'oss-eu-central-1.aliyuncs.com'   => '欧洲中部 1 法兰克福',
        'oss-eu-west-1.aliyuncs.com'      => '英国 1 伦敦',
        'oss-me-east-1.aliyuncs.com'      => '中东东部 1 迪拜',
    );

}