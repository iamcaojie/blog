<?php
namespace app\blog\controller;

use think\View;

class Python
{
    public function index($page=1)
    {
        // echo $page;
        $view = new View();
        return $view->fetch("contents/contents");
    }
    public function detail($id=1)
    {
        
        $view = new View();
        return $view->fetch("detail/detail");
    }
}
