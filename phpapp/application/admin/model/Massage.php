<?php 
namespace app\admin\model;

use think\Model;


class Massage extends Model
{
    // 静态方法，查询所有数据
    // sql:select * from _massage;
    public static function getMassageList($page,$limit)
    {
        $list = self::where('delete_time',null) -> limit(($page-1)*$limit,$limit) -> select();
        $count = self::where('delete_time',null) -> count();
        return ["code"=>0,"msg"=>"列表查询完成","count"=>$count,"data"=>$list];
    }
    
    public static function createMassage($data)
    {
        self::create($data);
        return ["data"=>""];
    }
    
    public static function editMassage($data)
    {
        self::update($data);
        return ["data"=>""];
    }
    
    public static function deleteMassage($data)
    {
        self::destroy($data);
        return ["data"=>""];
    }
    
    public static function queryMassage($data)
    {
        //pass
    }
}
