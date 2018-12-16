<?php 
namespace app\admin\model;

use think\Model;


class Weblinks extends Model
{
    
    // 静态方法，查询所有数据
    // sql:select * from _weblinks;
    public static function getWeblinksList()
    {
        return self::select();
    }
    
    public static function createWeblinks($data)
    {
        self::create($data);
        return ["data"=>""];
    }
    
    public static function editWeblinks($data)
    {
        self::update($data);
        return ["data"=>""];
    }
    
    public static function deleteWeblinks($data)
    {
        self::destroy($data);
        return ["data"=>""];
    }
    
    public static function queryWeblinks($data)
    {
        //pass
    }
}
