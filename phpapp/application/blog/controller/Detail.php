<?php
namespace app\blog\controller;

use app\admin\model\Blog as BlogModel;
use app\admin\model\Follow;
use app\admin\model\Users as UsersModel;
use app\admin\model\Comments as CommentsModel;
use app\admin\model\Reply as ReplyModel;
use app\admin\model\Follow as FollowModel;

class Detail extends Base
{
    public function index($id)
    {
        $blogDetail = BlogModel::queryBlog($id);
        if($blogDetail['code']<0){
            return json(['code'=>-1,'msg'=>'文章不存在']);
        }
        // 统计访问量
        // pass
        // 获取评论
        $blogCommentData = CommentsModel::queryComments($id);
//        dump(json($blogCommentData));die;
        return view("detail/detail",[
            'id' => $id,
            'blogDetail' => $blogDetail['data'],
            'blogComments' => $blogCommentData
        ]);
    }
    // 提交评论
    public function comment()
    {
        $data = input("post.");
        // 验证数据合法性
        $userID = session('user')['id'];
        if(!$userID){
            return json(['code'=>-1,'msg'=>'未登录']);
        }
        $data['user_id'] = $userID;
        $data['comment_text'] = htmlentities($data['comment_text']);
        $info = CommentsModel::createComments($data);
        if($info){
            $info = CommentsModel::formatComment([$info]);
            return json(['code'=>0,'msg'=>'评论成功','data'=>$info]);
        }else{
            return json(['code'=>0,'msg'=>'评论失败']);
        }
    }

    // 切换点赞，取消赞
    public function likeBlog($blogId)
    {
        $userID = session('user')['id'];
        if(!$userID){
            return json(['code'=>-1,'msg'=>'未登录']);
        }
        // UsersModel::
    }

    // 切换关注，取消关注
    public function followUser($userId,$followUserId)
    {
        $userID = session('user')['id'];
        if(!$userID){
            return json(['code'=>-1,'msg'=>'未登录']);
        }

        $info = FollowModel::followUser($userId,$followUserId);
        if($info){
            return json(['code'=>0,'msg'=>'关注成功']);
        }else{
            return json(['code'=>0,'msg'=>'关注失败']);
        }

    }

    // 回复评论
    public function replyComment()
    {
        $data = input('post.');
        // 判断用户是否登录
        if(!session('user')){
            return json(['code'=>-1,'msg'=>'未登录']);
        }
        $userId = session('user')['id'];
        // 判断评论是否存在
        $commentData = CommentsModel::get($data['comment_id']);
        if(!$commentData){
            return json(['code'=>-1,'msg'=>'评论不存在']);
        }
        // 写入回复数据
        $data['user_id'] = $userId;
        $data['reply_text'] = htmlentities($data['reply_text']);
        $info = ReplyModel::reply($data);
        if($info){
            return json(['code'=> 0, 'msg'=>'回复成功','data'=>$info]);
        }else{
            return json(['code'=> -1, 'msg'=>'回复失败']);
        }
    }
}
