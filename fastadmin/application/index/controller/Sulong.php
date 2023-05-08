<?php

namespace app\index\controller;
require_once "../../../vendor/autoload.php";
use Workerman\Worker;
use Workerman\Connection\TcpConnection;
use think\db;
/**
 * 首页接口
 */
$global_uid = 0;

class Sulong
{
    function index(){

    }
// 当客户端连上来时分配uid，并保存连接，并通知所有客户端
    function handle_connection($connection)
    {
        global $text_worker, $global_uid;
        // 为这个连接分配一个uid
        $connection->uid = ++$global_uid;
    }
// 当客户端发送消息过来时，转发给所有人
    function handle_message(TcpConnection $connection, $data)
    {
        global $worker;
        foreach($worker->connections as $conn)
        {
            $conn->send("user[{$connection->uid}] said: $data");
        }
    }
// 当客户端断开时，广播给所有客户端
    function handle_close($connection)
    {
        global $worker;
        foreach($worker->connections as $conn)
        {
            $conn->send("user[{$connection->uid}] logout");
        }
    }
}

// 创建一个文本协议的Worker监听2347接口
$worker = new Worker("websocket://0.0.0.0:2000");

$my_object = new Sulong();
// 只启动1个进程，这样方便客户端之间传输数据
$worker->count = 1;
// 调用类的方法
//$worker->onWorkerStart = array($my_object, 'onWorkerStart');
$worker->onConnect     = array($my_object, 'handle_connection');
$worker->onMessage     = array($my_object, 'handle_message');
$worker->onClose       = array($my_object, 'handle_close');
//$worker->onWorkerStop  = array($my_object, 'onWorkerStop');
Worker::runAll();
