<?php
namespace app\api\model\system;

use think\Model;
use app\lib\exception\user\UserException;
use think\Exception;

class User extends Model
{

    protected $table = 'system_user';

    /**
     * @param $params
     * @throws UserException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function createUser($params)
    {
        $user = self::where('username', $params['username'])->find();
        if ($user) {
            throw new UserException([
                'msg' => '用户名重复，请重新输入',
                'error_code' => 20004
            ]);
        }
        $user = self::where('email', $params['email'])->find();
        if ($user) {
            throw new UserException([
                'msg' => '注册邮箱重复，请重新输入',
                'error_code' => 20004
            ]);
        }
        $params['password'] = md5($params['password']);
        $params['admin'] = 1;
        $params['active'] = 1;
        self::create($params);
    }

    /**
     * @param $params
     * @return array
     * @throws \think\exception\DbException
     */
    public static function getAdminUsers($params)
    {
        $group = [];
        if (array_key_exists('group_id', $params)) $group = ['group_id' => $params['group_id']];

        list($start, $count) = paginate();

        $userList = self::where('admin', '<>', 2)
            ->where($group)
            ->field('password,create_time,update_time', true);

        $totalNums = $userList->count();
        $userList = $userList->limit($start, $count)->select();

        $userList = array_map(function ($item) {
            $group = LinGroup::get($item['group_id']);
            $item['group_name'] = $group['name'];
            return $item;
        }, $userList->toArray());

        $result = [
            'collection' => $userList,
            'total_nums' => $totalNums
        ];

        return $result;
    }

    /**
     * @param $params
     * @throws UserException
     */
    public static function resetPassword($params)
    {
        $user = User::find($params['uid']);
        if (!$user) {
            throw new UserException();
        }

        $user->password = md5($params['new_password']);
        $user->save();
    }

    /**
     * @param $uid
     * @throws UserException
     */
    public static function deleteUser($uid)
    {
        $user = User::find($uid);
        if (!$user) {
            throw new UserException();
        }

        User::destroy($uid);
    }

    /**
     * @param $params
     * @throws UserException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function updateUser($params)
    {
        $user = User::find($params['uid']);
        if (!$user) {
            throw new UserException();
        }

        $emailExist = self::where('email', $params['email'])->find();
        if ($emailExist && $params['email'] != $user['email']) {
            throw new UserException([
                'msg' => '注册邮箱重复，请重新输入',
                'error_code' => 20004
            ]);
        }

        $user->save($params);

    }


    /**
     * @param $params [url,uid]
     * @throws UserException
     */
    public static function updateUserAvatar($uid,$url){
        $user = User::find($uid);
        if (!$user) {
            throw new UserException();
        }
        $user->avatar = $url;
        $user->save();
    }

    /**
     * @param $username
     * @param $password
     * @return array|\PDOStatement|string|\think\Model
     * @throws UserException
     */
    public static function verify($username, $password)
    {
        try {

            $user = self::where('username', $username)->findOrFail();
        } catch (Exception $ex) {
            throw new UserException();
        }

        if (!$user->status) {
            throw new UserException([
                'msg' => '账户已被禁用，请联系管理员',
                'error_code' => 20003
            ]);
        }

        if (!self::checkPassword($user->password, $password)) {
            throw new UserException([
                'msg' => '密码错误，请重新输入',
                'error_code' => 20001
            ]);
        }

        return $user->hidden(['password']);

    }

    /**
     * @param $uid
     * @return array|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws UserException
     */
    public static function getUserByUID($uid)
    {
        try {
            $user = self::field('password', true)
                ->findOrFail($uid)->toArray();
        } catch (Exception $ex) {
            throw new UserException();
        }

        $auths = LinAuth::getAuthByGroupID($user['group_id']);

        $auths = empty($auths) ? [] : split_modules($auths);

        $user['auths'] = $auths;

        return $user;
    }


    private static function checkPassword($md5Password, $password)
    {
        return $md5Password === md5($password);
    }


}