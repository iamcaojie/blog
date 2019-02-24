<?php 
namespace app\admin\model;

use think\Model;


class Users extends Model
{

    // 静态方法，查询所有数据
    // sql:select * from _users;
    public static function getUsersList()
    {
        return self::select();
    }
    
    public static function createUsers($data)
    {
        self::create($data);
        return ["data"=>"创建用户成功"];
    }
    
    public static function editUsers($data)
    {
        self::update($data,['username'=>$data['username']],true);
        return ["data"=>""];
    }
    
    public static function deleteUsers($data)
    {
        self::destroy($data);
        return ["data"=>""];
    }
    
    public static function validateUser($data)
    {
       $userData = self::where('username',$data["username"])
               -> where('password',$data["password"]) 
               -> find();
       return $userData;
    }
    public static function queryUser($data)
    {
        $userData = self::where('username',$data["username"])
               -> find();
       return $userData;
    }
}
