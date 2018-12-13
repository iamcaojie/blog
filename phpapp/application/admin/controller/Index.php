<?php
namespace app\admin\controller;

use think\View;
use think\Cookie;
use app\admin\model\Users;
use app\admin\model\Web;
use app\admin\model\Blog;

// 全部方法需登陆验证
// 除Index控制器其余全为后台ajax获取提交地址
class Index
{
    public function index()
    {
        cookie(['prefix' => 'think_', 'expire' => 3600]);
        cookie('name', 'value', 3600);
        $view = new View();
        return $view->fetch("admin/admin");
    }

    // 以下为ajax后台提交地址
    // 网站状态
    public function webStatus($switch='off')
    {
        echo $switch;
        Web::where('id', '1')
            ->where('name', 'blog')
            ->update(['status' => $switch]);
    }


    
    // 
    
    
    
    
}
