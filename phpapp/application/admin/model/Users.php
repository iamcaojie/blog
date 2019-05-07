<?php 
namespace app\admin\model;

use think\Model;


class Users extends Model
{
    // 查询用户
    public static function getUsersList($page, $limit)
    {
        return self::limit(($page-1)*$limit,$limit)
            -> select();
    }

    // 创建用户
    public static function createUsers($data)
    {
        $info = self::create($data);
        return $info;
    }

    // 编辑用户
    public static function editUsers($data)
    {
        $info = self::update($data,['username'=>$data['username']],true);
        return $info;
    }

    // 删除用户
    public static function deleteUsers($data)
    {
        $info = self::destroy($data);
        return $info;
    }

    // 验证用户
    public static function validateUser($data)
    {
       $userData = self::where('username',$data["username"])
               -> where('password',$data["password"]) 
               -> find();
       return $userData;
    }

    // 查询是否存在用户名
    public static function queryUser($username)
    {
        $userData = self::where('username',$username)
               -> find();
       return $userData;
    }

    // 查询昵称
    public static function isExistNickName($nickname)
    {
        $isExist = self::where('nickname',$nickname)
            -> find();
        return $isExist;
    }

    // 修改昵称
    public static function editNickName($useId,$nickName)
    {
        $info = self::update(['id'=>$useId,'nickname'=>$nickName]);
        return $info;
    }

    // 查询头像地址
    public static function getAvatar($userId)
    {
        $userData = self::get($userId);
        $userImage = db('image')
            ->where('id',$userData['avatar_image_id'])
            ->find();
        $address = db('imagecate')
            ->where('id',$userImage['imagecate_id'])
            ->find()['dir'];
        $imageUrl = '/uploads/'.$address.'/'. $userImage['address'].'.'.$userImage['ext'];
        return $imageUrl;
    }

    // 搜索用户
    public static function searchUsers($k)
    {
        $userData = self::where('nickname','like','%'.$k.'%')
            ->select();
        return $userData;
    }
}
