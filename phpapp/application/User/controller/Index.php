<?php
namespace app\user\controller;

use app\blog\controller\Base;
use app\admin\model\Users as UsersModel;
use app\admin\model\Blog as BlogModel;
use app\admin\model\Comments as CommentsModel;
use app\admin\model\Follow as FollowModel;

class Index extends Base
{
    // 用户显示页面
    public function index($id = 1)
    {
        // 判断用户是否存在
        if(!UsersModel::get($id)){
            $this->redirect('/');
        }

        // 获取用户文章，评论，，粉丝
        $userBlog = BlogModel::getUserBlog($id);
        $this ->assign(['userBlogData'=>$userBlog]);
        // 获取用户评论
        $userComments = CommentsModel::getUserComments($id);
        $this ->assign(['userCommentsData'=>$userComments]);
        // 获取用户关注

        // 获取用户粉丝

        // 未登录，全部显示'加关注'
        if(!session('?user')){
            return view('user/user');
        }
        // 已登录，不是本人，显示'加关注','已关注','互相关注',用户界面
        if(session('user')['id'] != $id){
            // 用户界面（关注，取消关注）
            return view('user/user');
        }
        // 已登录，是本人，显示'加关注','已关注','互相关注',用户后台
        if(session('user')['id'] == $id){
            // 用户后台（文章发布，修改，删除，仅能修改自己的，关注，取消关注）
            return view('user/my');
        }
    }

    //
    public function follow()
    {
        // 是否登录
        if(!session('?user')){
            return json(['code'=>-1,'msg'=>'请登录后关注']);
        }
        // 参数是否正确
        if(!isset(input('post.')['follow_user_id'])){
            return json(['code'=>-1,'msg'=>'无参数']);
        }
        $followUserId = input('post.')['follow_user_id'];
        if(!is_numeric($followUserId)){
            return json(['code'=>-1,'msg'=>'关注用户错误']);
        }
        $userId = session('user')['id'];
        $info = FollowModel::followUser($userId,$followUserId);
        return $info;
    }
}
