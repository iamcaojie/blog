<?php
namespace app\blog\controller;

use app\admin\model\Blog as Blogmodel;
use app\admin\model\Comments as Commentsmodel;

class Detail extends Base
{
    public function index($id)
    {
        $detail = Blogmodel::queryBlog($id);
        if($detail['code']<0){
            return json(['msg'=>'文章不存在']);
        }
        $userName = session('user')['username'];
        $blogComment = Commentsmodel::queryComments($id);
        return view("detail/detail",[
            'id' => $id,
            'username' => $userName,
            'blogdetail' => $detail['data'],
            'blogcomments' => $blogComment['data']
        ]);
    }
    public function comment()
    {
        $data = input("post.");
        // 验证数据合法性
        $userID = session('user')['user_id'];
        if(!$userID){
            return json(['code'=>-1,'msg'=>'非法操作']);
        }
        $data['user_id'] = $userID;
        $data['comment_text'] = htmlentities($data['comment_text']);
        return json(Commentsmodel::createComments($data));
    }
    // 获取评论
    public function getcomments()
    {
        
    }
}
