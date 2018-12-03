<?php
namespace app\admin\controller;

use think\View;
use think\Cookie;
use app\admin\model\User;

class Index
{
    public function index()
    {
        cookie(['prefix' => 'think_', 'expire' => 3600]);
        cookie('name', 'value', 3600);
        $view = new View();
        return $view->fetch("admin/admin");
    }
}
