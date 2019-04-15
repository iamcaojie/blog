<?php
namespace app\admin\controller;

use app\admin\model\Web as Webmodel;

// 每个方法为同名模型的函数

class Account extends Base
{
    public function index()
    {
        return view('account/account');
    }
}