<?php
namespace app\admin\controller;

use think\View;
use think\Cookie;
use app\admin\model\Users;
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

    // 以下为ajax后台提交地址
    // 网站状态
    public function webStatus($switch='off')
    {
        echo $switch;
        Web::where('id', '1')
            ->where('name', 'blog')
            ->update(['status' => $switch]);
    }

    // 查询博客
    public function queryblog($action='query',$id=1,$page=1,$limit=10)
    {   
        $blog = New Blog;
        // 根据关键字调用模型方法，返回json数据
        switch ($action)
        {
        case 'getbloglist'://获取全部博客,layui表格组件所需数据
            return json($blog->getBlogList($page,$limit));
            break;
        case 'queryblog'://根据id获取博客
            return json($blog->queryBlog($id));
            // print_r(json($blog->queryBlog($id)));
            break;
        case 'query':
            return '查询错误';
            break;
        default:
            return '查询关键词错误';
        }
    }
    
    // 新增博客
    public function createblog()
    {
        $blog = New Blog;
        $data = input('post.');
        $blog ->blog_title = $data['blog_title'];
        $blog ->blog_text = $data['blog_text'];
        $blog ->allowField(true)->save();
        return json(["code"=>0, "msg"=>"保存成功"]);
    }
    
    // 编辑博客
    public function editblog()
    {
        // 可修改表单字段，避免和数据库一致
        $data = input('post.');
        $blog = Blog::get($data['id']);
        $blog -> blog_title = $data['blog_title'];
        $blog -> blog_text = $data['blog_text'];
        $blog -> allowField(true) -> save();
        if ($data['id']==1){
            return json(["code"=>0, "msg"=>"自动保存完成"]);
        }else{
            return json(["code"=>0, "msg"=>"编辑成功"]);
        }
        
    }
    
    // 软删除博客
    public function deleteblog($id)
    {   
        $blog = New Blog;
        return json($blog->deleteBlog($id));
    }
    
    // 
    
    
    
    
}
