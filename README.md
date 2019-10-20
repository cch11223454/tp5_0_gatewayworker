```
tp5.0结合gatewayworker，实现tp5.0框架内运行gatewayworker，业务逻辑类中可以使用tp5.0框架内的数据库操作类及助手函数
主要文件
/apps/websocket/controller/Run.php   --启动文件
/apps/websocket/controller/Events.php  --业务逻辑
/apps/common/logic/GatewayWorkerLogic.php    --部分Gateway类接口的再次封装类
/websocket.php     --入口文件
/websocket.html     --长连接测试文件，可直接用浏览器运行

/extend/workweman      --workerman与gatewayworker的核心类包
/vender/GatewayClient/GatewayClient.php



运行：在项目根目录下执行：php wensocket.php start
windows系统下双击 start_for_win.bat运行
```
