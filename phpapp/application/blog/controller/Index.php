<?php
namespace app\blog\controller;

use think\View;
use think\Request;
use app\blog\model\User;

class Index
{
    public function index()
    {
        $view = new View();
        return $view->fetch("blog/blog");
    }
    
    public function hello($name,$age)
    {
        $request = Request::instance();
        // echo ''.$request-> has('name','post');
        // echo Request::instance()-> has('name','post');
        // echo ''.$request-> has('name','get');
        // echo Request::instance()-> has('name','get');
        echo $request->param('name');
        echo '访问ip地址：' . $request->ip() . '<br/>';
        $info = Request::instance()->header();
        echo $info['accept'].'<br/>';
        echo $info['accept-encoding'].'<br/>';
        echo $info['user-agent'].'<br/>';
        if (Request::instance()->isGet()) echo "当前为 GET 请求";
        return 'Hello,name:'.$name.' age:'.$age;
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
