<?php 
namespace app\admin\model;

use think\Model;


class AuthRule extends Model
{

    // 静态方法，查询所有数据
    // sql:select * from _auth_rule;
    public static function getAuthRuleList()
    {
        return self::select();
    }
    
    public static function createAuthRule($data)
    {
        self::create($data);
        return ["data"=>""];
    }
    
    public static function editAuthRule($data)
    {
        self::update($data);
        return ["data"=>""];
    }
    
    public static function deleteAuthRule($data)
    {
        self::destroy($data);
        return ["data"=>""];
    }
    
    public static function queryAuthRule($data)
    {
        //pass
    }
}
