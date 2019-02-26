<?php
namespace app\blog\controller;

use app\admin\model\Blog as Blogmodel;
use app\admin\model\Comments as Commentsmodel;

class Contents
{
    public function index($page=1,$limit=10)
    {
        $bloglist = Blogmodel::getBlogList($page,$limit);
        return view("contents/contents",[
            'bloglist'=>$bloglist['data'],
            'pagecount'=>$bloglist['count']
        ]);
    }
    public function detail($id)
    {
        $userName = session('user')['username'];
        $detail = Blogmodel::queryBlog($id);
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
