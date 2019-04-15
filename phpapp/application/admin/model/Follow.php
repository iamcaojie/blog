<?php
namespace app\admin\model;

use think\Model;

class Follow extends Model
{
    protected static $UFstatus = [0=>'互相关注',1=>'已关注'];
    protected static $FUstatus = [0=>'互相关注',1=>'对方已关注'];

    // 格式化列表数据，加入详细用户数据，加入访问者与列表中每个用户的关系
    protected static function formatData($viewerId,$data)
    {
        foreach ($data as $key=>$value)
        {
            $value['user'] = db('users')
                ->where('id',$value['user_id'])
                ->find();
            $value['follow'] = db('users')
                ->where('id',$value['followed_user'])
                ->find();
            $value['status'] = self::queryStatus($viewerId,$value['user_id']);
        }
        return $data;
    }

    // 关注，取消关注用户，已关注取消，未关注直接关注，$viewerId为发起关注的用户，当前登录用户
    public static function followUser($viewerId,$followUserId)
    {
        // 判断是否为自己
        if($viewerId == $followUserId){
            return ['code'=>-1, 'msg'=>'不能关注自己'];
        }
        $userData = db('users')
            -> where('id',$viewerId)
            -> find();
        $followUserData = db('users')
            -> where('id',$followUserId)
            -> find();
        // 判断用户，关注用户是否存在
        if(!($userData && $followUserData)){
            return ['code'=>-1, 'msg'=>'用户不存在'];
        }
        // 判断关注状态（已关注，未关注）
        $status = self::where('user_id',$viewerId)
            ->where('followed_user',$followUserId)
            ->find();
        if($status){
            // 已关注的取消关注
            self::destroy($status['id']);
        }else{
            // 未关注的关注
            self::create(['user_id'=>$viewerId,'followed_user'=>$followUserId]);
        }
        // 修改状态，对于每个用户来说都有已关注(1)，互相关注(0)两种状态
        $userStatus = self::where('user_id',$viewerId)
            ->where('followed_user',$followUserId)
            ->find();
        $followStatus = self::where('user_id',$followUserId)
            ->where('followed_user',$viewerId)
            ->find();
        // 互相关注
        if($userStatus && $followStatus){
            $uInfo = self::update(['id'=>$userStatus['id'],'status'=>0]);
            $fInfo = self::update(['id'=>$followStatus['id'],'status'=>0]);
            if($uInfo && $fInfo){
                return ['code'=> 0, 'msg'=>'互相关注'];
            }
        }
        // 互相未关注
        if((!$userStatus) && (!$followStatus)){
            return ['code'=> 0, 'msg'=>'加关注'];
        }
        // 仅访问者关注
        if(($userStatus) && (!$followStatus)){
            $info = self::update(['id'=>$userStatus['id'],'status'=>1]);
            if($info){
                return ['code'=> 0, 'msg'=>'已关注'];
            }
        }
        // 被关注
        if((!$userStatus) && ($followStatus)){
            $info = self::update(['id'=>$followStatus['id'],'status'=>1]);
            if($info){
                return ['code'=> 0, 'msg'=>'对方已关注'];
            }
        }
    }

    // 查询用户关注列表，并显示访问者与列表中的状态
    public static function queryFollower($viewerId,$userId)
    {
        $followerList = self::where('user_id',$userId)->select();
        $followerList = self::formatData($viewerId,$followerList);
        return $followerList;
    }

    // 查询用户粉丝列表，并显示访问者与列表中的状态
    public static function queryFans($viewerId,$userId)
    {
        $fansList = self::where('followed_user',$userId)->select();
        $fansList = self::formatData($viewerId,$fansList);
        return $fansList;
    }

    // 查询某个用户和某个用户的状态，$viewerId代表访问者，$followUserId代表在页面上显示的用户
    public static function queryStatus($viewerId,$followUserId)
    {
        if($viewerId == $followUserId){
            return '本人';
        }
        // 先查一条
        $userStatus = self::where('user_id',$viewerId)
            ->where('followed_user',$followUserId)
            ->find();
        if($userStatus) {
            return self::$UFstatus[$userStatus['status']];
        }
        // 如果查不到，再查另一条
        $userStatus = self::where('user_id',$followUserId)
                ->where('followed_user',$viewerId)
                ->find();
        if($userStatus) {
            return self::$FUstatus[$userStatus['status']];
        }
        // 两条都不存在
        return '加关注';
    }
}