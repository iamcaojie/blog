<?php
namespace app\admin\model;

use think\Model;

class Follow
{
    // 关注，取消关注用户，已关注取消，未关注直接关注
    public static function followUser($userId,$followUserId)
    {
        // 判断是否为自己
        if($userId == $followUserId){
            return ['code'=>-1, 'msg'=>'不能关注自己'];
        }
        $userData = db('users')
            -> where('id',$userId)
            -> find();
        $followUserData = db('users')
            -> where('id',$followUserId)
            -> find();
        // 判断用户，关注用户是否存在
        if(!($userData && $followUserData)){
            return ['code'=>-1, 'msg'=>'用户不存在'];
        }
        // 判断关注状态（已关注，未关注），需要修改两条数据（对应关注的人也需要修改）

        // 已关注，取消关注
        // 未关注，关注
        // 获取状态，已关注，互相关注，加关注
    }

    // 查询关注列表
    public static function queryFollower($userId)
    {
        // 查询状态
        // 已关注，互相关注
    }

    // 查询粉丝列表
    public static function queryFans($userId)
    {
        // 未关注，互相关注
    }

}