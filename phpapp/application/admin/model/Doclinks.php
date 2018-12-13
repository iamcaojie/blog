<?php 
namespace app\admin\model;

use think\Model;

class Doclinks extends Model
{
    // 静态方法，查询所有数据
    // sql:select * from _doclinks;
    public static function getDoclinksList()
    {
        return self::select();
    }
    
    public static function createDoclinks($data)
    {
        self::create($data);
        return ["data"=>""];
    }
    
    public static function editDoclinks($data)
    {
        self::update($data);
        return ["data"=>""];
    }
    
    public static function deleteDoclinks($data)
    {
        self::destroy($data);
        return ["data"=>""];
    }
    
    public static function queryDoclinks($data)
    {
        //pass
    }
}