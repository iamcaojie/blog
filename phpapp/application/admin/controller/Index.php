<?php
namespace app\admin\controller;

use think\View;
use think\Cookie;
use app\admin\model\User;
use app\admin\model\Web;

class Index
{
    public function index()
    {
        cookie(['prefix' => 'think_', 'expire' => 3600]);
        cookie('name', 'value', 3600);
        $user = User::get(1);
        $user->name = "caojieaeqw";
        echo $user->name;
        $user->save();
        $web = Web::get(1);
        $web->name = "caojieaeqw";
        echo $web->name;
        $web->save();
        // $view = new View();
        // return $view->fetch("admin/admin");
    }
}
