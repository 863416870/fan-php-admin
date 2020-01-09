<?php

namespace app\index\controller;

use library\Controller;
use library\File as FF;
use think\Db;

/**
 * 文件管理
 * Class User
 * @package app\admin\controller
 */
class File extends Controller
{

    public function index(){
//        $result = FF::instance('oss')->down("fanguojie/item/7fce90bce3307383bd2828a3cc85d98.png");

        $result = FF::instance('oss')->save("fanguojie/item/ceshi1.png",file_get_contents("C:\Users\Administrator\Desktop\\7fce90bce3307383bd2828a3cc85d98.png"));
        return writeJson(201, $result, '成功');
    }

    public function get(){
        $result = FF::instance('oss')->get("fanguojie/item/ceshi1.png");
        file_put_contents("C:\Users\Administrator\Desktop\ceshi.png",$result);
        return writeJson(201, '', '成功');
    }

}
