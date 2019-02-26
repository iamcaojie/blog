<?php
namespace app\blog\controller;

use think\Request;
use think\Controller;
use think\Db;
use app\admin\model\Cate as Catemodel;
use app\blog\model\Massage;

class Index extends Controller
{
    public function index()
    {
        $userName = session('user')['username'];
        $cateData = Catemodel::getCateList();
        $webData = Db::name('web')->where('id',1)->find();
        $domain = $webData['domain'];
        return view("blog/blog",
            ["username"=>$userName,
                'domain'=>$domain,
                'cates'=>$cateData
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
