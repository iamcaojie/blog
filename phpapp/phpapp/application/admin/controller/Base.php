<?php
namespace app\admin\controller;

// 所有需登录的控制器继承此类
class Base extends Controller 
{
    public function _initialize()
    {
        echo '1';
    }

}