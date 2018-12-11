<?php
namespace app\blog\controller;

use think\View;
use think\Request;
// use app\blog\model\Users;
use app\blog\model\Massage;

class Index
{
    public function index()
    {
        $view = new View();
        return $view->fetch("blog/blog");
    }
    
    public function getMassage()
    {
        // TODO 过滤验证
        $massage = new Massage;
        $data = input('post.');
        $massage -> massage_title = $data['massage_title'];
        $massage -> massage_text = $data['massage_text'];
        $massage -> save();
        return ["code"=>0, "msg"=>"提交成功"];
    }   

    public function tem()
    {
        $request = Request::instance();
        echo 'root:' . $request->root() . '<br/>';
        echo 'url without query: ' . $request->baseUrl() . '<br/>';
        return 'index page';
    }
}
