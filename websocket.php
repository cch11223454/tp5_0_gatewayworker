<?php
ini_set('display_errors', 'on');
if(strpos(strtolower(PHP_OS), 'win') === 0)
{
    exit("websocket.php not support windows.\n");
}
$is_cli = PHP_SAPI == 'cli' ? true : false;

if(!$is_cli) exit('Please run in cli mode！');
// 检查扩展
if(!extension_loaded('pcntl'))
{
    exit("Please install pcntl extension. See http://doc3.workerman.net/appendices/install-extension.html\n");
}
if(!extension_loaded('posix'))
{
    exit("Please install posix extension. See http://doc3.workerman.net/appendices/install-extension.html\n");
}
define('APP_PATH', __DIR__ . '/apps/');

//绑定默认模块和控制器
define('BIND_MODULE','websocket/Run');

require __DIR__ . '/thinkphp/base.php';// 加载框架基础文件

\think\App::route(false);// 路由
\think\App::run()->send();// 执行应用