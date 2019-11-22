<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/1
 * Time: 12:48
 */

namespace app\api\controller\system;

use app\lib\auth\AuthMap;
use app\lib\exception\role\RoleException;
use app\api\model\system\User as SystemUser;
use app\api\model\system\Role as SystemRole;
use app\api\model\system\Auth as SystemAuth;
use think\facade\Hook;
use think\Request;

class Admin
{
    /**
     * 配置hidden后，这个权限信息不会挂载到权限图，获取所有可分配的权限时不会显示这个权限
     * @auth('查询所有用户','管理员','hidden')
     * @param Request $request
     * @return array
     * @throws \think\exception\DbException
     */
    public function getAdminUsers(Request $request)
    {
        $params = $request->get();

        $result = SystemUser::getAdminUsers($params);

        return writeJson(201, $result, '成功');
    }


    /**
     * @auth('修改用户密码','管理员','hidden')
     * @param Request $request
     * @return \think\response\Json
     * @throws \app\lib\exception\user\UserException
     */
    public function changeUserPassword(Request $request)
    {
        $params = $request->param();

        SystemUser::resetPassword($params);
        return writeJson(201, '', '密码修改成功');
    }

    /**
     * @auth('删除用户','管理员','hidden')
     * @param $uid
     * @return \think\response\Json
     * @throws \app\lib\exception\user\UserException
     */
    public function deleteUser($uid)
    {
        SystemUser::deleteUser($uid);
        Hook::listen('logger', '删除了用户id为' . $uid . '的用户');
        return writeJson(201, '', '操作成功');
    }


    /**
     * @auth('管理员更新用户信息','管理员','hidden')
     * @param Request $request
     * @return \think\response\Json
     * @throws \app\lib\exception\user\UserException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function updateUser(Request $request)
    {
        $params = $request->param();
        SystemUser::updateUser($params);

        return writeJson(201, '', '操作成功');
    }

    /**
     * @auth('查询所有权限组','管理员','hidden')
     * @return mixed
     */

    public function getGroupAll()
    {
        $result = SystemRole::all();

        return $result;
    }

    /**
     * @auth('查询一个权限组及其权限','管理员','hidden')
     * @param $id
     * @return array|\PDOStatement|string|\think\Model
     * @throws RoleException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getRole($id)
    {
        $result = SystemRole::getRoleByID($id);

        return $result;
    }


    /**
     * @auth('删除一个权限组','管理员','hidden')
     * @param $id
     * @return \think\response\Json
     * @throws RoleException
     */
    public function deleteRole($id)
    {
        //查询当前权限组下是否存在用户
        $hasUser = SystemUser::get(['role_id'=>$id]);
        if($hasUser)
        {
            throw new RoleException([
                'code' => 412,
                'msg' => '分组下存在用户，删除分组失败',
                'error_code' => 30005
            ]);
        }
        SystemRole::deleteRoleAuth($id);
        Hook::listen('logger', '删除了权限组id为' . $id . '的权限组');
        return writeJson(201, '', '删除分组成功');
    }


    /**
     * @auth('新建权限组','管理员','hidden')
     * @param Request $request
     * @return \think\response\Json
     * @throws \ReflectionException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws RoleException
     */
    public function createRole(Request $request)
    {
        $params = $request->post();

        SystemRole::createRole($params);
        return writeJson(201, '', '成功');
    }

    /**
     * @auth('更新一个权限组','管理员','hidden')
     * @param Request $request
     * @param $id
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function updateRole(Request $request, $id)
    {
        $params = $request->put();

        $group = SystemRole::find($id);
        if (!$group) {
            throw new RoleException([
                'code' => 404,
                'msg' => '指定的分组不存在',
                'errorCode' => 30003
            ]);
        }
        $group->save($params);
        return writeJson(201, '', '更新分组成功');
    }


    /**
     * @auth('查询所有可分配的权限','管理员','hidden')
     * @return array
     * @throws \ReflectionException
     * @throws \WangYu\exception\ReflexException
     */
    public function authority()
    {
        $result = (new AuthMap())->run();

        return $result;
    }

    /**
     * @auth('删除多个权限','管理员','hidden')
     * @param Request $request
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function removeAuths(Request $request)
    {
        $params = $request->post();

        SystemAuth::where(['role_id' => $params['role_id'], 'auth' => $params['auths']])
            ->delete();
        return writeJson(201, '', '删除权限成功');
    }

    /**
     * @auth('分配多个权限','管理员','hidden')
     * @param Request $request
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function dispatchAuths(Request $request)
    {
        $params = $request->post();

        SystemAuth::dispatchAuths($params);
        Hook::listen('logger', '修改了id为' . $params['group_id'] . '的权限');
        return writeJson(201, '', '添加权限成功');
    }


}