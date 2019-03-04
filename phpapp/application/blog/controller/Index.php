<?php
namespace app\blog\controller;

use think\Controller;
use think\Db;
use app\admin\model\Web as Webmodel;
use app\admin\model\Cate as Catemodel;


class Index extends Controller
{
    public function index()
    {
//        $redis = new \Redis();
//        echo $redis->connect('127.0.0.1', 6379);
        $userName = session('user')['username'];
        $cateData = Catemodel::getCateList();
        $webData = Webmodel::get(1);
        return view("blog/blog",
            ["username"=>$userName,
                'webdata'=>$webData,
                'cates'=>$cateData,
                ]
            );
    }
    
    public function getMassage()
    {
        // TODO 过滤验证
        $massage = new Massage;
        $data = input('post.');
        $massage -> massage_title = $data['massage_title'];
        $massage -> contact = $data['contact'];
        $massage -> massage_text = $data['massage_text'];
        $massage -> save();
        return ["code"=>0, "msg"=>"提交成功"];
    }
}
