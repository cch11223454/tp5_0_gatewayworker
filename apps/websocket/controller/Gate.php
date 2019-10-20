<?php
namespace app\websocket\controller;
use Workerman\Worker;
use Workerman\WebServer;
use GatewayWorker\BusinessWorker;
use GatewayWorker\Gateway;


/**
 * 构造函数
 * @access public
 */
class Gate
{

    public function __construct()
    {
        //由于是手动添加，因此需要注册命名空间，方便自动加载，具体代码路径以实际情况为准
        \think\Loader::addNamespace([
            'Workerman' => EXTEND_PATH . 'workerman/workerman',
            'GatewayWorker' => EXTEND_PATH . 'workerman/gateway-worker/src',
        ]);
        // 初始化 gateway 进程
        $gateway = new Gateway("websocket://0.0.0.0:38282");

        //心跳检测时间间隔 单位：秒。如果设置为0代表不做任何心跳检测。
        $gateway->pingInterval = 55;

        //客户端必须定时发送心跳给服务端，
        //pingNotResponseLimit*pingInterval=55秒内没有任何数据发来则关闭对应连接，并触发onClose。
        $gateway->pingNotResponseLimit = 1;

        //代表服务端允许客户端不发送心跳，服务端不会因为客户端长时间没发送数据而断开连接。
        //$gateway->pingNotResponseLimit = 0;

        // 服务端定时向客户端发送的数据（不推荐，这里仅测试）
        $gateway->pingData = '{"type":"test","msg":"这是一条来自服务端的测试消息"}';


        //设置Gateway进程的名称，方便status命令中查看统计
        $gateway->name = 'WebSocketService';

        //设置Gateway进程的数量，以便充分利用多cpu资源
        $gateway->count = 4;

        //lanIp是Gateway所在服务器的内网IP，默认填写127.0.0.1即可。
        //多服务器分布式部署的时候需要填写真实的内网ip，不能填写127.0.0.1。
        //注意：lanIp只能填写真实ip，不能填写域名或者其它字符串，无论如何都不能写0.0.0.0
        $gateway->lanIp = '127.0.0.1';

        /**
         * Gateway进程启动后会监听一个本机端口，用来给BusinessWorker提供链接服务，然后Gateway与BusinessWorker之间就通过这个连接通讯。这里设置的是Gateway监听本机端口的起始端口。比如启动了4个Gateway进程，startPort为2000，则每个Gateway进程分别启动的本地端口一般为2000、2001、2002、2003。
         * 当本机有多个Gateway/BusinessWorker项目时，需要把每个项目的startPort设置成不同的段
         *
         */
        $gateway->startPort = 4200;

        //注册服务地址
        $gateway->registerAddress = '127.0.0.1:31238';
        //运行所有Worker;
        Worker::runAll();
    }
}

