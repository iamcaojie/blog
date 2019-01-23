<?php
namespace app\admin\controller;

use think\View;
use think\Cookie;
use app\admin\model\Users;
use app\admin\model\Web;
use app\admin\model\Blog;
use app\admin\model\Cate;

// 全部方法需登陆验证
// 除Index控制器其余全为后台ajax获取提交地址
class Index
{
    public function index()
    {
//        cookie(['prefix' => 'think_', 'expire' => 3600]);
//        cookie('name', 'value', 3600);
        $catelist = Cate::getCateList();
        $view = new View();
        return $view->fetch("admin/admin",['catelist' => $catelist]);
    }

    // 网站状态修改
    public function webStatus($switch)
    {
        Web::where('id', '1')
            ->where('name', 'blog')
            ->update(['status' => $switch]);
        if(Web::get(1)->status == 'on'){
           return json(["code"=>0,"msg"=>"网站已开启"]);
        }else{
           return json(["code"=>0,"msg"=>"网站已关闭"]);
        }
    }


    
    // 
    
    
    
    
}
