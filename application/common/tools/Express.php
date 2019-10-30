<?php
/**
 * 快递100查询接口
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/9/5
 * Time: 17:32
 */

namespace app\common\tools;


class Express
{
    /**
     * 查询物流信息
     * @param string $code 快递公司编辑
     * @param string $number 快递物流编号
     * @return array
     */
    public static function query($code, $number)
    {
        if (in_array($code, ['debangkuaidi'])) $code = 'debangwuliu';
        list($microtime, $clientIp, $list) = [time(), request()->ip(), []];
        $options = ['header' => ['Host' => 'www.kuaidi100.com', 'CLIENT-IP' => $clientIp, 'X-FORWARDED-FOR' => $clientIp], 'cookie_file' => env('runtime_path') . 'temp/cookie'];
        $location = "https://sp0.baidu.com/9_Q4sjW91Qh3otqbppnN2DJv/pae/channel/data/asyncqury?cb=callback&appid=4001&com={$code}&nu={$number}&vcode=&token=&_={$microtime}";
        $result = json_decode(str_replace('/**/callback(', '', trim(Http::get($location, [], $options), ')')), true);
        if (empty($result['data']['info']['context'])) { // 第一次可能失败，这里尝试第二次查询
            $result = json_decode(str_replace('/**/callback(', '', trim(Http::get($location, [], $options), ')')), true);
            if (empty($result['data']['info']['context'])) {
                return ['message' => 'ok', 'com' => $code, 'nu' => $number, 'data' => $list];
            }
        }
        foreach ($result['data']['info']['context'] as $vo) $list[] = [
            'time' => date('Y-m-d H:i:s', $vo['time']), 'ftime' => date('Y-m-d H:i:s', $vo['time']), 'context' => $vo['desc'],
        ];
        return ['message' => 'ok', 'com' => $code, 'nu' => $number, 'data' => $list];
    }
}