<?php
use \think\Db;
// 检测PHP环境
if (version_compare(PHP_VERSION, '7.0.0', '<') || version_compare(PHP_VERSION, '7.3.0', '>')) {
    header("Content-type: text/html; charset=utf-8");
    die('PHP 版本必须 5.6 至 7.2 !');
}

// 定义应用目录

define('APP_PATH', __DIR__ . '/apps/');
define('APP_RELATIVE_PATH', '/apps/');
// 加载框架引导文件
//
require __DIR__ . '/thinkphp/start.php';

