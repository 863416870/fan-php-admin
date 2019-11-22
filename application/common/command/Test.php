<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/22
 * Time: 17:40
 */
namespace app\common\command;
use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\Db;
use think\facade\Log;
class Test extends Command
{

    //定义任务名和描述
    protected function configure(){
        $this->setName('test')->setDescription("test 测试");
    }

    //调用该类时,会自动运行execute方法
    protected function execute(Input $input, Output $output){
//        set_time_limit(0);
//        @ob_end_clean();
//        @ob_implicit_flush(1);
//        ini_set('memory_limit','100M');
//        # echo substr_replace('18858281234','****',3,4);
//        header("Content-type: text/html; charset=utf-8");
//        date_default_timezone_set('Asia/Shanghai');
//
//
//        $res = $this->truncateTable('rong360');
//        //招联-281  小赢易贷-201  捷信-276 //200    小赢卡贷 //238  小赢新易贷
//        //订单状态【99：全部；0：申请中；1：已结算；2：未通过】
//        //默认1：每页取50条
//        $page = 0;
//        while(true){
//            $page++;
//            $res = Rong360Service::order('20190915',date('Ymd'),$status=99,$page); //订单
//            $res = json_decode($res,true);
//            if( empty($res['data']['body'])){
//                echo"已同步完成\n\r";exit();
//            }
//
//            foreach($res['data']['body'] as $k=>$v){
//                $data['product_id'] = $v['product_id'];
//                $data['mask_mobile'] = $v['mask_mobile'];
//                $data['order_money'] = $v['order_money'];
//                $data['product_name'] = $v['product_name'];
//                $data['order_time'] = $v['order_time'];
//                if($v['order_status'] == 0){
//                    $status = '申请中';
//                }elseif($v['order_status'] == 1){
//                    $status = '已结算';
//
//                }elseif($v['order_status'] == 2){
//                    $status = '未通过';
//                }else{
//                    $status = '全部';
//                }
//                $data['order_status'] = $status;
//                Db::table(Config('database.prefix').'rong360')->insert($data);
//                #$insert_data[] = $data;
//
//            }
            echo "同步第页完成\n\r";

//           if(Db::table(Config('database.prefix').'rong360')->insertAll($insert_data)){
//               sleep(1);
//               echo "同步第{$page}页完成\n\r";
//           }




//        }



    }


//    //清空数据表
//    private function truncateTable($table = ''){
//        //        file_put_contents('./crontab--.php','c',FILE_APPEND);
//        return Db::query("truncate table ".Config('database.prefix').$table);
//    }


}