<?php
namespace app\websocket\controller;
use Workerman\Worker;
use GatewayWorker\Register;
use GatewayWorker\BusinessWorker;
use GatewayWorker\Gateway;

//控制器无需继承Controller

/**
 * 构造函数
 * @access public
 */
class Run
{

    public function __construct()
    {
        //由于是手动添加，因此需要注册命名空间，方便自动加载，具体代码路径以实际情况为准
        \think\Loader::addNamespace([
            'Workerman' => EXTEND_PATH . 'workerman/workerman',
            'GatewayWorker' => EXTEND_PATH . 'workerman/gateway-worker/src',
        ]);
        //初始化各个GatewayWorker
        new Register('text://0.0.0.0:11238');

        //初始化 bussinessWorker 进程
        $worker = new BusinessWorker();
        $worker->name = 'YourAppBusinessWorker';
        $worker->count = 4;
        $worker->registerAddress = '127.0.0.1:11238';
        
        //设置处理业务的类,此处制定Events的命名空间
        $worker->eventHandler = '\app\websocket\controller\Events';
        // 初始化 gateway 进程
        $gateway = new Gateway("websocket://0.0.0.0:18282");

        //服务端心跳检测
        $gateway->pingInterval = 30;
        $gateway->pingNotResponseLimit = 0;
        // 服务端定时向客户端发送的数据
        $gateway->pingData = '{"type":"test","msg":"这是一条来自服务端的测试消息"}';


        $gateway->name = 'YourAppName';
        $gateway->count = 4;
        $gateway->lanIp = '127.0.0.1';
        $gateway->startPort = 2900;
        $gateway->registerAddress = '127.0.0.1:11238';
        //运行所有Worker;
        Worker::runAll();
    }
}

