<?php 
namespace app\admin\model;

use think\Model;


class Linkcate extends Model
{
    
    // 静态方法，查询所有数据
    // sql:select * from _linkcate;
    public static function getLinkcateList()
    {
        return self::select();
    }
    
    public static function createLinkcate($data)
    {
        self::create($data);
        return ["code"=> 0, "data"=>"创建链接分类成功"];
    }
    
    public static function editLinkcate($data)
    {
        self::update($data);
        return ["data"=>""];
    }
    
    public static function deleteLinkcate($data)
    {
        self::destroy($data);
        return ["data"=>""];
    }
    
    public static function queryLinkcate($data)
    {
        //pass
    }
}
