<?php
ini_set('display_errors', 'on');
$is_cli = PHP_SAPI == 'cli' ? true : false;

if(!$is_cli) exit('Please run in cli mode！');


define('APP_PATH', __DIR__ . '/apps/');

//绑定默认模块和控制器
define('BIND_MODULE','websocket/Reg');

require __DIR__ . '/thinkphp/base.php';// 加载框架基础文件

\think\App::route(false);// 路由
\think\App::run()->send();// 执行应用