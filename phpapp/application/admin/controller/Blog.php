<?php
namespace app\admin\controller;

use app\admin\model\Blog as Blogmodel;
use app\admin\model\Cate as Catemodel;


class Blog extends Base
{
    // 查询博客 
    // get /admin/blog/queryblog/action/getbloglist/page/1/limit/10
    // get /admin/blog/queryblog/action/queryblog/id/1
    public function queryblog($action='query',$id=1,$page=1,$limit=10)
    {   
        // 根据关键字调用模型方法
        switch ($action)
        {
        case 'getbloglist'://获取全部博客,layui表格组件所需数据
            return json(Blogmodel::getBlogList($page,$limit));
            break;
        case 'queryblog'://根据id获取博客
            return json(Blogmodel::queryBlog($id));
            break;
        case 'query':
            return '查询错误';
            break;
        default:
            return '查询关键词错误';
        }
    }
    
    // 新增博客(分类直接写入对应cate_id,只能向中间表添加已有标签数据)
    // post /admin/blog/createblog
    public function createblog()
    {
        $data = input('post.');
        $userID = session('user')['user_id'];
        if(!$userID){
            return json(["code"=>-1, "msg"=>"非法操作"]);
        }
        $data["blogdata"]['user_id'] = $userID;
        Blogmodel::createBlog($data);
        return json(["code"=>0, "msg"=>"保存成功"]);
    }
    
    // 编辑博客 -> 编辑已有分类 -> 向中间表修改标签数据
    // post /admin/blog/editblog
    public function editblog()
    {
        // 可修改表单字段，避免和数据库一致，不用保存关联数据
        $data = input('post.');
        $blogData = $data["blogdata"];
        if ($blogData['id']==1){
            $blog = Blogmodel::get(1);
            $blog -> blog_title = $blogData['blog_title'];
            $blog -> unique_tag = $blogData['unique_tag'];
            $blog -> blog_text = $blogData['blog_text'];
            $blog -> blog_html = $blogData['blog_html'];
            $blog -> allowField(true) -> save();
            return json(["code"=>0, "msg"=>"自动保存完成"]);
        }else{
            return json(Blogmodel::editBlog($data));
        }
    }
    
    // 软删除博客->
    // post /admin/blog/deleteblog
    public function deleteblog($id)
    {   
        $blog = New Blogmodel;
        return json($blog->deleteBlog($id));
    }
}