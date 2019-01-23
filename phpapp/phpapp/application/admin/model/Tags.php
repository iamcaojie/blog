<?php 
namespace app\admin\model;

use think\Model;

class Tags extends Model
{
    // 
    // 博客与标签多对多关联
    public function blog()
    {
        return $this->belongsToMany('blog','think_blogs_tags','blog_id','tag_id');
    }
    
    // 静态方法，查询所有数据
    // sql:select * from _tags;
    public static function getTagsList()
    {
        return self::select();
    }
    
    public static function createTags($data)
    {
        self::create($data);
        return ["data"=>""];
    }
    
    public static function editTags($data)
    {
        self::update($data);
        return ["data"=>""];
    }
    
    public static function deleteTags($data)
    {
        self::destroy($data);
        return ["data"=>""];
    }
    
    public static function queryTags($data)
    {
        //pass
    }
}