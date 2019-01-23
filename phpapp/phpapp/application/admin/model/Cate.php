<?php 
namespace app\admin\model;

use think\Model;


class Cate extends Model
{
    // 一个分类对应多篇文章
    public function blog()
    {   
        return $this->hasMany('Blog','cate_id','id');
    }   
    // 静态方法，查询所有数据
    // sql:select * from _cate;
    public static function getCateList()
    {
        return self::select();
    }
    
    public static function createCate($data)
    {
        self::create($data);
        return ["data"=>""];
    }
    
    public static function editCate($data)
    {
        self::update($data);
        return ["data"=>""];
    }
    
    public static function deleteCate($data)
    {
        self::destroy($data);
        return ["data"=>""];
    }
    
    public static function queryCate($data)
    {
        //pass
    }
}
