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
    public static function queryUser($data)
    {
        $userData = self::where('username',$data["username"])
               -> find();
       return $userData;
    }
}
