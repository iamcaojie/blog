<?php
namespace app\blog\controller;

use think\View;
use \think\Request;

class Index
{
    public function index()
    {
        $view = new View();
        return $view->fetch("blog/blog");
    }
    
    public function hello($name,$age)
    {
        return 'Hello,name:'.$name.' age:'.$age;
    }    

    public function jsondata()
    {
        $data = ['name'=>'thinkphp','url'=>'iamcaojie.com'];
        return json(['data'=>$data,'code'=>'code','message'=>'Done']);
    }
    public function xmldata()
    {
        $data = ['name'=>'thinkphp','url'=>'iamcaojie.com'];
        return xml(['data'=>$data,'code'=>'code','message'=>'Done']);
    }
    
    public function jsonpdata()
    {
        $data = ['name'=>'thinkphp','url'=>'iamcaojie.com'];
        return jsonp(['data'=>$data,'code'=>'code','message'=>'Done']);
    }
    public function tem()
    {
        $request = Request::instance();
        echo 'root:' . $request->root() . '<br/>';
        echo 'url without query: ' . $request->baseUrl() . '<br/>';
        return 'index page';
        // 继承 \think\Controller类
        // return $this->fetch('index');
        
    }
}
