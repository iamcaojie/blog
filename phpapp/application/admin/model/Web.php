<?php 
namespace app\admin\model;

use think\Model;


class Web extends Model
{
 
    // 静态方法，查询所有数据
    // sql:select * from _web;
    public static function getWebList()
    {
        return self::select();
    }
    
    public static function createWeb($data)
    {
        self::create($data);
        return ["data"=>""];
    }
    
    public static function editWeb($data)
    {
        self::update($data);
        return ["data"=>""];
    }
    
    public static function deleteWeb($data)
    {
        self::destroy($data);
        return ["data"=>""];
    }
    
    public static function queryWeb($data)
    {
        //pass
    }
}
