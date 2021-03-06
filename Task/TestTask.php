<?php
namespace MyApp\Task;

use Imi\Task\Annotation\Task;
use Imi\Task\Interfaces\ITaskHandler;
use Imi\Task\TaskParam;
use Swoole\Server;

/**
 * @Task("Test1")
 */
class TestTask implements ITaskHandler
{
    /**
     * 任务处理方法
     * @param TaskParam $param
     * @param Server $server
     * @param int $taskID
     * @param int $WorkerID
     */
    public function handle(TaskParam $param, Server $server, int $taskID, int $WorkerID)
    {
        $data = $param->getData();
        return date('Y-m-d H:i:s', $data['time']);
    }
 
    /**
     * 任务结束时触发
     * @param Server $server
     * @param int $taskID
     * @param mixed $data
     * @return void
     */
    public function finish(Server $server, int $taskID, $data)
    {
    }

}