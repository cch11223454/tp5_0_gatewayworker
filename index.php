<?php
use \think\Db;
/**
 * COOLS
 * ============================================================================
 * * 版权所有 2013-2028 杭州千家网络有限公司，并保留所有权利。
 * * 网站地址: http://www.vnet1000.com
 * ----------------------------------------------------------------------------
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: Fushengji 2019-08-23 $
 */
// 检测PHP环境
if (version_compare(PHP_VERSION, '7.0.0', '<') || version_compare(PHP_VERSION, '7.3.0', '>')) {
    header("Content-type: text/html; charset=utf-8");
    die('PHP 版本必须 7.0 至 7.2 !');
}

if (!extension_loaded('redis')) exit('Redis扩展未开启');// 判断是否开启redis扩展
if (!extension_loaded('mysqli')) exit('mysqli扩展未开启');
if (!extension_loaded('pdo')) exit('pdo扩展未开启');
if (!extension_loaded('pdo_mysql')) exit('pdo_mysql扩展未开启');
if (!extension_loaded('gd')) exit('gd库未开启');
if (!extension_loaded('mbstring')) exit('mbstring扩展未开启');
if (!extension_loaded('curl')) exit('curl扩展未开启');

error_reporting(E_ERROR | E_WARNING | E_PARSE);//报告运行时错误

defined('UPLOAD_PATH') or define('UPLOAD_PATH', 'public/upload/'); // 编辑器图片上传路径
$http = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] && $_SERVER['HTTPS'] != 'off') ? 'https' : 'http';
define('SITE_URL', $http . '://' . $_SERVER['HTTP_HOST']); // 网站域名
// 定义时间
define('NOW_TIME', $_SERVER['REQUEST_TIME']);
// 定义应用目录
//define('APP_PATH', __DIR__ . '/application/');
define('APP_PATH', __DIR__ . '/apps/');
define('APP_RELATIVE_PATH', '/apps/');
define('MULT_DOMAIN', true);
// 加载框架引导文件
//

if (!MULT_DOMAIN) {
    require __DIR__ . '/thinkphp/start.php';
} else {
    require __DIR__ . '/thinkphp/base.php';// 加载框架基础文件
    $domain = $_SERVER['HTTP_HOST'];
    $database = include_once __DIR__.DS.'apps'.DS.'database.php';
    $config = include_once __DIR__.DS.'apps'.DS.'config.php';
    $site = Db::connect('mysql://'.$database['username'].':'.$database['password'].'@'.$database['hostname'].':'.$database['hostport'].'/'.$database['database'].'#utf8')->name($database['prefix'].'site')->where(['site_status' => 1])->column('site_uuid', 'site_domain');

//开启域名部署后
    switch ($domain) {
        case 'www.qjthink.com':
            $module = 'manager';//
            $controller = 'Index';
            $route = true;// 开启路由
            break;
        default:
            $suuid = $site[$domain];
            if(!$suuid) exit('error domain');
            $module = 'wisdom';// wisdom模块
            $controller = 'Index';
            $route = true;// 关闭路由
            setcookie($config['cookie']['prefix'].'suuid', $suuid, time()+3600);;
            break;
    }

    $module = $module ?? 'manager';
    $controller = $controller ?? 'Index';
    //exit;
    //define('BIND_MODULE', $module);
    //\think\Route::bind($module ?? 'home');// 绑定当前入口文件到模块
    define('BIND_MODULE', $module . '/' . $controller);
    \think\App::route($route ?? true);// 路由
    \think\App::run()->send();// 执行应用
}

