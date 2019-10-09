<?php

namespace app\common\logic;

use think\Db;
use think\Session;

class GatewayWorkerLogic
{
    public $gateway = null;

    public function __construct()
    {
        vendor("GatewayClient.GatewayClient");
        $this->gateway = new \GatewayClient;
    }

    private function get_uidlist_by_group($uid)
    {
        $worker = $this->gateway;
        return $worker::getUidListByGroup($uid);
    }


    private function join_group($client_id, $group)
    {
        $worker = $this->gateway;
        $worker::joinGroup($client_id, $group);
    }

    private function send_to_group($group, $message)
    {
        $worker = $this->gateway;
        $worker::sendToGroup($group, $message);
    }

    private function send_to_uid($uid, $message)
    {
        $worker = $this->gateway;
        $worker::sendToUid($uid, $message);
    }

    private function is_uid_online($uid)
    {
        $worker = $this->gateway;
        return $worker::isUidOnline($uid);
    }

    private function send_to_all($message)
    {
        $worker = $this->gateway;
        $worker::sendToAll($message);
    }
}