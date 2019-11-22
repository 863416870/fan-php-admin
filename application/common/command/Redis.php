<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/9/9
 * Time: 14:47
 */
namespace app\common\command;

use app\api\controller\redis\Subscribe as RedisSubscribe;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\Output;

class Redis extends Command
{
    // 配置指令  php think redis psubscribe & 后台挂起进程
    public function configure()
    {
        $this->setName('redis')
            ->addArgument('type', Argument::REQUIRED, "the type of the task that pay needs to run")
            ->setDescription('this is payment system command line tools');
    }

    // 执行指令
    public function execute(Input $input, Output $output)
    {
        $type = $input->getArgument('type');
        if ($type == 'psubscribe') {
            // 发布订阅任务
            $this->psubscribe();
        }
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