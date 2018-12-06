<?php
namespace app\admin\controller;

use think\View;
use think\Cookie;
use app\admin\model\User;
use app\admin\model\Web;
use app\admin\model\Blog;

// 全部方法需登陆验证
class Index
{
    public function index()
    {
        cookie(['prefix' => 'think_', 'expire' => 3600]);
        cookie('name', 'value', 3600);
        $view = new View();
        return $view->fetch("admin/admin");
    }
    // 以下为前台显示的ajax获取页面，get方法
    // 网站状态页
    public function webStatus($status=1)
    {
        
    }
    // 发布文章页
    public function getCreateBlogView()
    {
        return view('admin/createblogview');
    }
    // 文章列表页
    public function getBlogListView()
    {
        
    }
    // 以下为ajax后台提交地址，post方法
    // 查询博客
    public function queryblog($action='query',$id)
    {   
        $blog = New Blog;
        // 根据关键字调用模型方法，返回json数据
        switch ($action)
        {
        case 'getbloglist'://获取全部博客
            return json($blog->getBlogList());
            break;
        case 'queryblog'://根据id获取博客
            return json($blog->queryBlog($id));
            break;
        case 'query':
            return '查询错误';
            break;
        default:
            return '查询关键词错误';
        }
    }
    // 新增博客，需登陆
    public function createblog()
    {
        $blog = New Blog;
        $data = input('post.');
        $blog ->blog_title = $data['blog_title'];
        $blog ->allowField(true)->save();
        // 验证
        print_r($data);
    }
    // 编辑博客，需登陆
    public function editblog()
    {
        // 可修改表单字段，避免和数据库一致
        $data = input('post.');
        $blog = Blog::get($data['id']);
        $blog ->blog_title = $data['blog_title'];
        $blog ->allowField(true)->save();
    }
    // 删除博客
    public function deleteblog()
    {
        $blog = New Blog;
        print_r($data);
    }
}
