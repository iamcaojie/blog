<?php
namespace app\admin\controller;

use app\admin\model\Users;
use app\admin\model\Web;
use app\admin\model\Blog;
use app\admin\model\Cate;
use app\admin\model\Linkcate;


// 除Index控制器其余全为后台ajax获取提交地址
class Index extends Base
{
    public function index()
    {
        $request = request();
        $ip = $request -> ip();
        // 获取网站数据
        $webData = Web::get(1);
        // 获取轮播数据

        // 获取分类数据
        $cateList = Cate::getCateList();
        // 获取链接分类数据
        $linkCateList = Linkcate::getLinkcateList();
        // 获取用户数据
        $userName = session('user');
        return view("admin/admin",
            ['username' => $userName,
                'webdata' => $webData,
                'catelist' => $cateList,
                'linkcatelist' => $linkCateList,
                'ip' => $ip
            ]);
    }

    // 获取所有权限
    public function a()
    {
        print_r(get_class_methods('Index'));
    }

}
