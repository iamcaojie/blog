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
        $webData = Web::get(1);
        $cateList = Cate::getCateList();
        $linkCateList = Linkcate::getLinkcateList();
        $userName = session('user')['username'];
        return view("admin/admin",
            ['username' => $userName,
                'webdata' => $webData,
                'catelist' => $cateList,
                'linkcatelist' => $linkCateList,
                'ip' => $ip
            ]);
    }
    
}
