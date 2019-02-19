<?php 
namespace app\admin\model;

use think\Model;


class AuthGroupAccess extends Model
{
 
    // 静态方法，查询所有数据
    // sql:select * from _auth_aroup_access;
    public static function getAuthGroupAccessList()
    {
        return self::select();
    }
    
    public static function createAuthGroupAccess($data)
    {
        self::create($data);
        return ["data"=>""];
    }
    
    public static function editAuthGroupAccess($data)
    {
        self::update($data);
        return ["data"=>""];
    }
    
    public static function deleteAuthGroupAccess($data)
    {
        self::destroy($data);
        return ["data"=>""];
    }
    
    public static function queryAuthGroupAccess($data)
    {
        //pass
    }
}
