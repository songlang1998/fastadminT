<?php

namespace app\push\controller;

use think\worker\Server;
use think\db;
class Worker extends Server
{
    protected $socket = 'websocket://0.0.0.0:2000';

    /**
     * 收到信息
     * @param $connection
     * @param $data
     */
    public function onMessage($connection, $data)
    {
//        dump();die;
        foreach ($this->worker->connections as $con){
            $con->send("user[{$connection->id}] said: $data");
        }
    }
    /**
     * 当连接建立时触发的回调函数
     * @param $connection
     */
    public function onConnect($connection)
    {
//        dump($connection);
    }

    /**
     * 当连接断开时触发的回调函数
     * @param $connection
     */
    public function onClose($connection)
    {

    }

    /**
     * 当客户端的连接上发生错误时触发
     * @param $connection
     * @param $code
     * @param $msg
     */
    public function onError($connection, $code, $msg)
    {
        echo "error $code $msg\n";
    }

    /**
     * 每个进程启动
     * @param $worker
     */
    public function onWorkerStart($worker)
    {

    }
}
