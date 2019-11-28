<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\facade\Route;

Route::group('', function () {
    Route::group('system', function () {
        // 账户相关接口分组
        Route::group('user', function () {
            // 登陆接口
            Route::post('login', 'api/system.User/login');
            // 刷新令牌
            Route::get('refresh', 'api/system.User/refresh');
            // 查询自己拥有的权限
            Route::get('auths', 'api/system.User/getAllowedApis');
            // 注册一个用户
            Route::post('register', 'api/system.User/register');
            // 更新头像
            Route::put('avatar','api/system.User/setAvatar');
            // 查询自己信息
            Route::get('information','api/system.User/getInformation');
        });
        // 管理类接口
        Route::group('admin', function () {
            // 查询所有权限组
            Route::get('group/all', 'api/system.Admin/getGroupAll');
            // 查询一个权限组及其权限
            Route::get('group/:id', 'api/system.Admin/getGroup');
            // 删除一个权限组
            Route::delete('group/:id', 'api/system.Admin/deleteGroup');
            // 更新一个权限组
            Route::put('group/:id', 'api/system.Admin/updateGroup');
            // 新建权限组
            Route::post('group', 'api/system.Admin/createGroup');
            // 查询所有可分配的权限
            Route::get('authority', 'api/system.Admin/authority');
            // 删除多个权限
            Route::post('remove', 'api/system.Admin/removeAuths');
            // 添加多个权限
            Route::post('/dispatch/patch', 'api/system.Admin/dispatchAuths');
            // 查询所有用户
            Route::get('users', 'api/system.Admin/getAdminUsers');
            // 修改用户密码
            Route::put('password/:uid', 'api/system.Admin/changeUserPassword');
            // 删除用户
            Route::delete(':uid', 'api/system.Admin/deleteUser');
            // 更新用户信息
            Route::put(':uid', 'api/system.Admin/updateUser');

        });
        // 日志类接口
        Route::get('log/', 'api/system.Log/getLogs');
        Route::get('log/users', 'api/system.Log/getUsers');
        Route::get('log/search', 'api/system.Log/getUserLogs');

        //上传文件类接口
        Route::post('file/','api/system.File/postFile');
    });
    Route::group('v1', function () {
        // 查询所有图书
        Route::get('book/', 'api/v1.Book/getBooks');
        // 新建图书
        Route::post('book/', 'api/v1.Book/create');
        // 查询指定bid的图书
        Route::get('book/:bid', 'api/v1.Book/getBook');
        // 搜索图书

        // 更新图书
        Route::put('book/:bid', 'api/v1.Book/update');
        // 删除图书
        Route::delete('book/:bid', 'api/v1.Book/delete');
    });
    Route::group("wechat",function (){
        Route::get('userlogin', 'wechat/User/login');
    });
})->middleware([])->allowCrossDomain();

