<?php
/**
 * Created by PhpStorm
 * User: 范国洁
 * Date: 2019/9/1
 * Time: 13:21
 */

namespace app\common\model;

use app\lib\exception\logger\LoggerException;
use think\Model;

class Log extends Model
{
    protected $table = "system_log";

    /**
     * @param $params
     * @return array
     * @throws LoggerException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getLogs($params)
    {
        $filter = [];
        if (isset($params['name'])) {
            $filter ['user_name'] = $params['name'];
        }

        if (isset($params['start']) && isset($params['end'])) {
            $filter['time'] = [$params['start'], $params['end']];
        }

        list($start, $count) = paginate();

        $logs = self::withSearch(['user_name', 'time'], $filter)
            ->order('time desc');

        $totalNums = $logs->count();
        $logs = $logs->limit($start, $count)->select();

        if (!count($logs)) throw new LoggerException(['code' => 404, 'msg' => '没有查询到更多日志']);

        $result = [
            'collection' => $logs,
            'total_nums' => $totalNums
        ];
        return $result;

    }

    public function searchUserNameAttr($query, $value, $data)
    {
        if (!empty($value)) {
            $query->where('user_name', $value);
        }
    }

    public function searchTimeAttr($query, $value, $data)
    {
        if (!empty($value)) {
            $query->whereBetweenTime('time', $value[0], $value[1]);
        }
    }
}