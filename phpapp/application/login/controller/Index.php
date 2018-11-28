<?php
namespace app\login\controller;

use think\View;

class Index
{
    public function index()
    {
        $view = new View();
        return $view->fetch("login/login");
    }
}
