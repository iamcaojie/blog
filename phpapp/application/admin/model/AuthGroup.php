<?php 
namespace app\admin\model;

use think\Model;


class AuthGroup extends Model
{

    public static function getAuthGroupList()
    {
        $data = self::select();
        $authGroupData = sortTree1($data, $pid=0, $level=0);
        return $authGroupData;
    }
    
    public static function createAuthGroup($data)
    {
        $info = self::create($data);
        return $info;
    }
    
    public static function editAuthGroup($data)
    {
        $info = self::update($data);
        return $info;
    }
    
    public static function deleteAuthGroup($data)
    {
        $info = self::destroy($data);
        return $info;
    }
    
    public static function queryAuthGroup($data)
    {
        //pass
    }
}
