<?php
namespace app\websocket\controller;
use Workerman\Worker;
use GatewayWorker\Register;


//控制器无需继承Controller

/**
 * 构造函数
 * @access public
 */
class Reg
{

    public function __construct()
    {
        //由于是手动添加，因此需要注册命名空间，方便自动加载，具体代码路径以实际情况为准
        \think\Loader::addNamespace([
            'Workerman' => EXTEND_PATH . 'workerman/workerman',
            'GatewayWorker' => EXTEND_PATH . 'workerman/gateway-worker/src',
        ]);
        // register 必须是text协议
        new Register('text://0.0.0.0:31238');

        //运行所有Worker;
        Worker::runAll();
    }
}

