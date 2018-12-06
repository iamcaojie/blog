<?php
namespace app\admin\controller;

use think\View;
use think\Cookie;
use app\admin\model\User;
use app\admin\model\Web;
use app\admin\model\Blog;

class Index
{
    public function index()
    {
        cookie(['prefix' => 'think_', 'expire' => 3600]);
        cookie('name', 'value', 3600);
        $view = new View();
        return $view->fetch("admin/admin");
    }
    public function webStatus($status=1)
    {
        
    }
    // http://localhost/admin/index/blog/action/query/id/1
    public function blog($action='query',$id)
    {   
        $blog = New Blog;
        return json($blog->queryBlog($id));
    }
}
