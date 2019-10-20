<?php
namespace app\websocket\controller;
use Workerman\Worker;
use Workerman\WebServer;
use GatewayWorker\Gateway;
use GatewayWorker\BusinessWorker;


//控制器无需继承Controller

/**
 * 构造函数
 * @access public
 */
class Business
{

    public function __construct()
    {
        //由于是手动添加，因此需要注册命名空间，方便自动加载，具体代码路径以实际情况为准
        \think\Loader::addNamespace([
            'Workerman' => EXTEND_PATH . 'workerman/workerman',
            'GatewayWorker' => EXTEND_PATH . 'workerman/gateway-worker/src',
        ]);
        //初始化 bussinessWorker 进程
        $worker = new BusinessWorker();

        //设置BusinessWorker进程的名称，方便status命令中查看统计
        $worker->name = 'WebSocketBusinessWorker';

        //设置BusinessWorker进程的数量，以便充分利用多cpu资源
        $worker->count = 4;
        //注册服务地址，只写格式类似于 '127.0.0.1:1236'
        $worker->registerAddress = '127.0.0.1:31238';

        //设置使用哪个类来处理业务，默认值是Events，即默认使用Events.php中的Events类来处理业务。
        //业务类至少要实现onMessage静态方法，onConnect和onClose静态方法可以不用实现。
        //此处制定Events的命名空间
        $worker->eventHandler = '\app\websocket\controller\Events';
        //运行所有Worker;
        Worker::runAll();
    }
}

