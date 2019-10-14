<?php
namespace app\websocket\controller;
use think\Controller;
use think\Request;
use \GatewayWorker\Lib\Gateway;

/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 * 继承tp5的controller
 */

class Events extends Controller
{
    public static function onWorkerStart($businessWorker)
    {
        echo "WorkerStart\n";
    }


    /**
     * 当客户端连接时触发
     * 如果业务不需此回调可以删除onConnect
     *
     * @param int $client_id 连接id
     */

    public static function onConnect($client_id)
    {
        echo "$client_id 连接成功 \n";

        Gateway::sendToClient($client_id, json_encode(array(
            'type'      => 'init',
            'client_id' => $client_id
        )));
    }

    /**
     * 当客户端发来消息时触发
     * @param int $client_id 连接id
     * @param mixed $message 具体消息
     */
    public static function onMessage($client_id, $message)
    {
        //向所有人发送
        //Gateway::sendToAll("$client_id said $message\r\n");
    }


    /**
     * 当用户断开连接时触发的方法
     * @param integer $client_id 断开连接的客户端client_id
     * @return void
     */
    public static function onClose($client_id)
    {
        // 广播 xxx logout

        echo "$client_id 断开连接 \n";
        //GateWay::sendToAll("client[$client_id] logout\n");
    }



}
