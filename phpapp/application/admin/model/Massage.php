<?php 
namespace app\admin\model;

use think\Model;


class Massage extends Model
{
    // 一个留言消息对应多篇文章
    public function blog()
    {   
        return $this->hasMany('Blog','massage_id','id');
    }   
    // 静态方法，查询所有数据
    // sql:select * from _massage;
    public static function getMassageList()
    {
        return self::select();
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
