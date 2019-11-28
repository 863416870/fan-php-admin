<?php
namespace app\index\controller;

use app\common\exception\BaseException;
use app\common\reflex\Reflex;
use app\common\tools\Data;
use app\common\tools\Express;
use app\common\tools\File;
use app\common\tools\Node;
use app\common\util\ExceptionUtil;
use Finecho\Logistics\Logistics;
use think\facade\Hook;
use think\Controller;

class Index extends Controller
{

    public $list = '[
        {"id":"1","name":"媒体(白名单)","pid":"0"},
        {"id":"2","name":"党媒公共平台","pid":"0"},
        {"id":"3","name":"政府机构","pid":"0"},
        {"id":"4","name":"其他","pid":"0"},
        {"id":"5","name":"中央媒体","pid":"1"},
        {"id":"6","name":"地方媒体","pid":"1"},
        {"id":"7","name":"门户媒体","pid":"4"},
        {"id":"8","name":"综合媒体","pid":"4"},
        {"id":"9","name":"专业媒体","pid":"4"},
        {"id":"11","name":"河北省","pid":"6"},
        {"id":"12","name":"山东省","pid":"6"},
        {"id":"13","name":"辽宁省","pid":"6"},
        {"id":"34","name":"北京","pid":"6"},
        {"id":"45","name":"视频","pid":"9"},
        {"id":"46","name":"教育","pid":"9"},
        {"id":"79","name":"法律","pid":"9"},
        {"id":"80","name":"其他","pid":"9"},
        {"id":"81","name":"文学","pid":"9"}]';

    /**
     * 入口跳转链接
     */
    public function index()
    {
        $this->redirect('@admin/login');
    }

//    public function index()
//    {
//        return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:) </h1><p> ThinkPHP V5.1<br/><span style="font-size:30px">12载初心不改（2006-2018） - 你值得信赖的PHP框架</span></p></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=64890268" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="eab4b9f840753f8e7"></think>';
//    }

    /**
     * @route('查询一个权限组及其权限')
     * @param string $name
     * @return string
     */
    public function hello($name = 'ThinkPHP5')
    {
        $class = new \ReflectionClass("app\index\controller\Index");


        // 类下面的所有方法的数组
        $methods = $class->getMethods();
        var_dump($methods);
        // 类下面所有含有@auth注解的方法的注解内容数组

        // 类下面所有含有@auth注解的方法的注解内容数组
        $methodAuthList = $this->getMethodsDoc($class, $methods);

        return 'hello,' . $name;
    }

    /**
     * @param $class
     * @param $array
     * @return array
     * @throws \WangYu\exception\ReflexException
     */
    private function getMethodsDoc($class, $array)
    {
        $data = [];
        foreach ($array as $value) {
            $reflex = new Reflex($class, $value->name);
            $authAnnotation = $reflex->get('route');
            var_dump($authAnnotation);

        }
    }

    public function ceshi(){
        Hook::listen('logger', '创建了一个用户');
        halt(ExceptionUtil::ParseExceptionMap());
        throw new BaseException(ExceptionUtil::ParseExceptionMap());
    }

    public function oss(){
        // 判断文件是否存在
         $a = File::instance('oss')->has("d9ab5a4114941c9d/9ab6033c454a716f.jpg");
         var_dump($a);
    }

    /**
     * 生成树状
     * @return \think\response\Json
     */
    public function arrTree(){
        $list = $this->list;
        $list = json_decode($list, true);
        $list = Data::arr2table($list);
        $list = Data::arr2tree($list);
        return writeJson(200,$list);
    }

    /**
     * 父找子
     * @return \think\response\Json
     */
    public function getArrSubIds(){
        $list = $this->list;
        $list = json_decode($list, true);
        $ids = Data::getArrSubIds($list,1);
        return writeJson(200,$ids);
    }

    /**
     * 父找子
     * @return \think\response\Json
     */
    public function getArrSupIds(){
        $list = $this->list;
        $list = json_decode($list, true);
        $ids = Data::getArrSupIds($list,[]);
        return writeJson(200,$ids);
    }

    /**
     * 获取当前节点
     * @return \think\response\Json
     */
    public function getCurrentNodes(){
        $currentNodes = Node::current();
        return writeJson(200,$currentNodes);
    }
    /**
     * 获取当前节点
     * @return \think\response\Json
     */
    public function getMethodTreeNode(){
        $getMethodTreeNode = Node::getTree(env('app_path'));
        return writeJson(200,$getMethodTreeNode);
    }

    public function getEnv(){
       return  env('app_path');
    }

    /**
     * 测试快递100
     */
    public function qd100(){
        $info = Express::query('yuantong','YT4058827811681');
        $info = Express::query('shentong','773001885407885');
        return writeJson(200,$info);
    }
}
