<?php
namespace app\admin\controller;

use app\admin\model\Comments as CommentsModel;

class Comments extends Base
{
    // 获取所有评论
    public function getCommentsList($page,$limit)
    {
        return json(CommentsModel::getCommentsList($page,$limit));
    }

    // 编辑评论
    public function editComments()
    {
        $data = input('post.');
        // 验证数据合法性
        $data = CommentsModel::editComments($data);
        return json(["code"=>0,"msg"=>"编辑评论成功"]);
    }
    
    // 查询评论
    public function queryComments()
    {
        //pass
    }
    
    // 删除评论，同时删除评论下的回复
    public function deleteComments()
    {
        $id = input('post.')['id'];
        // 验证数据合法性
        $info = CommentsModel::deleteComments($id);
        if($info){
            return json(["code"=>0,"msg"=>"删除评论成功"]);
        }else{
            return json(["code"=>0,"msg"=>"删除评论失败"]);
        }
    }
}