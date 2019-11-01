<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/1
 * Time: 16:08
 */

namespace app\api\model\system;

use think\Model;
use app\lib\exception\role\RoleException;
use think\Db;
use think\Exception;

class Role extends Model
{
    /**
     * @param $id
     * @return array|\PDOStatement|string|\think\Model
     * @throws RoleException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getRoleByID($id)
    {
        try {
            $role = self::findOrFail($id)->toArray();
        } catch (Exception $ex) {
            throw new RoleException([
                'code' => 404,
                'msg' => '指定的角色不存在',
                'errorCode' => 30003
            ]);
        }

        $auths = Auth::getAuthByRoleID($role['id']);

        $role['auths'] = empty($auths) ? [] : split_modules($auths);;

        return $role;

    }


    /**
     * @param $params
     * @throws RoleException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \ReflectionException
     * @throws \Exception
     */
    public static function createRole($params)
    {
        $role = self::where('name', $params['name'])->find();
        if ($role) {
            throw new RoleException([
                'errorCode' => 30004,
                'msg' => '角色已存在'
            ]);
        }

        Db::startTrans();
        try {
            $role = (new Role())->allowField(true)->create($params);

            $auths = [];

            foreach ($params['auths'] as $value) {
                $auth = findAuthModule($value);
                $auth['group_id'] = $role->id;
                array_push($auths, $auth);
            }

            (new Auth())->saveAll($auths);
            Db::commit();
        } catch (\Exception $ex) {
            Db::rollback();
            throw new RoleException([
                'errorCode' => 30001,
                'msg' => '分组创建失败'
            ]);
        }
    }
}