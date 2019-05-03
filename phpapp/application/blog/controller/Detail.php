<?php
namespace app\blog\controller;

use app\admin\model\Blog as BlogModel;
use app\admin\model\Users as UsersModel;
use app\admin\model\Comments as CommentsModel;
use app\admin\model\Reply as ReplyModel;
use app\admin\model\Follow as FollowModel;
use app\admin\model\Favorite as FavoriteModel;

class Detail extends Base
{
    public function index($id=1)
    {
        $blogDetail = BlogModel::queryBlog($id);
        if($blogDetail['code']<0){
            return json(['code'=>-1,'msg'=>'文章不存在']);
        }
        //当前用户是否收藏，与作者的关注关系
        if(!session('?user')){
            $this->assign('favoriteStatus',0);
            $this->assign('followStatus','未关注');
        }else{
            $authorId = $blogDetail['data']['user']['id'];
            $userId = session('user')['id'];
            $followStatus = FollowModel::queryStatus($userId,$authorId);
            $this->assign('followStatus',$followStatus);
            $favoriteStatus = FavoriteModel::getFavorite(session('user')['id'],$blogDetail['data']['id']);
            $this->assign('favoriteStatus',$favoriteStatus);
        }

        // 获取评论
        $blogCommentData = CommentsModel::queryComments($id);
        return view("detail/detail",[
            'id' => $id,
            'blogDetail' => $blogDetail['data'],
            'blogComments' => $blogCommentData
        ]);
    }

    // 收藏，取消收藏
    public function favorite()
    {
        $blogId = input("post.")['id'];
        $userID = session('user')['id'];

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
