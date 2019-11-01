<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/1
 * Time: 16:22
 */

namespace app\api\model\system;

use think\Model;

class Auth extends Model
{
    protected $hidden = ['id'];

    /**
     * @param $id
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getAuthByRoleID($id)
    {
        $result = self::where('role_id', $id)
            ->field('role_id', true)
            ->select()->toArray();
        return $result;
    }

    /**
     * @param $params
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function dispatchAuths($params)
    {
        foreach ($params['auths'] as $value) {
            $auth = self::where(['role_id' => $params['role_id'], 'auth' => $value])->find();
            if (!$auth) {
                $authItem = findAuthModule($value);
                $authItem['role_id'] = $params['role_id'];
                self::create($authItem);
            }
        }
    }
}