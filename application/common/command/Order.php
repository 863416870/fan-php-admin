<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/9/9
 * Time: 14:47
 */
namespace app\common\command;

use app\index\service\RedisSubscribe;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\Output;
use app\common\tools\redis\RedisBase;

class Order extends Command
{
    // 配置指令  php think order psubscribe & 后台挂起进程
    public function configure()
    {
        $this->setName('order')
            ->addArgument('type', Argument::REQUIRED, "the type of the task that pay needs to run")
            ->setDescription('this is payment system command line tools');
    }

    // 执行指令
    public function execute(Input $input, Output $output)
    {
        $type = $input->getArgument('type');
        if ($type == 'psubscribe') {
            // 发布订阅任务
            $this->redisSetEx();
            $this->psubscribe();
        }
    }
    public function redisSetEx(){
        $redis = new RedisBase();
        $redis->setex("jue",5,111);
    }
    /**
     * Redis 发布订阅模式
     */
    private function psubscribe()
    {
        $service = new RedisSubscribe();
        $service->sub();
    }


}