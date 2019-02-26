<?php
namespace app\admin\controller;

use app\admin\model\Comments as Commentsmodel;

class Comments
{
    // 获取所有评论
    // /admin/comments/getcommentslist
    public function getCommentsList($page,$limit)
    {
        return json(Commentsmodel::getCommentsList($page,$limit));
    }
    
    // 创建评论，只能在评论页调用，需登录
    // /admin/comments/createcomments
    // public function createComments()
    // {
        // $data = input('post.');
        // 验证数据合法性
        // $data = Catemodel::createCate($data);
        // return json(["code"=>0,"msg"=>"创建分类成功"]);
    // }
    
    // 编辑评论
    // /admin/comments/editcomments
    public function editComments()
    {
        $data = input('post.');
        // 验证数据合法性
        $data = Commentsmodel::editComments($data);
        return json(["code"=>0,"msg"=>"编辑评论成功"]);
    }
    
    // 查询博客
    public function queryComments()
    {
        //pass
    }
    
    // 删除评论
    // 对博客文章无影响
    // /admin/comments/deletecomments
    public function deleteComments()
    {
        $data = input('post.');
        // 验证数据合法性
        $data = Catemodel::deleteComments($data);
        return json(["code"=>0,"msg"=>"删除分类成功"]);
    }
}