<?php
namespace app\admin\controller;

use app\admin\model\Blog as Blogmodel;

class Blog
{
    // 查询博客 
    // get /admin/blog/queryblog/getbloglist/page/?/limit/?
    // get /admin/blog/queryblog/queryblog/id/?
    public function queryblog($action='query',$id=1,$page=1,$limit=10)
    {   
        $blog = New Blogmodel;
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
    // post /admin/blog/createblog
    public function createblog()
    {
        $blog = New Blogmodel;
        $data = input('post.');
        $blog ->blog_title = $data['blog_title'];
        $blog ->blog_text = $data['blog_text'];
        $blog ->allowField(true)->save();
        return json(["code"=>0, "msg"=>"保存成功"]);
    }
    
    // 编辑博客
    // post /admin/blog/editblog
    public function editblog()
    {
        // 可修改表单字段，避免和数据库一致
        $data = input('post.');
        $blog = Blogmodel::get($data['id']);
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
    // post /admin/blog/deleteblog
    public function deleteblog($id)
    {   
        $blog = New Blogmodel;
        return json($blog->deleteBlog($id));
    }
}