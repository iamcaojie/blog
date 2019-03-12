<?php
namespace app\admin\controller;

use app\admin\model\Comments as Commentsmodel;

class Comments extends Base
{
    // 获取所有评论
    // /admin/comments/getcommentslist
    public function getCommentsList($page,$limit)
    {
        return json(Commentsmodel::getCommentsList($page,$limit));
    }

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
        $id = input('post.');
        // 验证数据合法性
        $data = Commentsmodel::deleteComments($id);
        return json(["code"=>0,"msg"=>"删除评论成功"]);
    }
}