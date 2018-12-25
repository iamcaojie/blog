<?php 
namespace app\admin\model;

use think\Model;

class Comments extends Model
{
    // 静态方法，查询所有数据
    // sql:select * from _comments;
    public static function getCommentsList()
    {
        return self::select();
    }
//     创建评论，只能在评论页调用
    public static function createComments($data)
    {
        self::create($data);
        return ["data"=>""];
    }
//     暂无需求
    public static function editComments($data)
    {
//        self::update($data);
//        return ["data"=>""];
    }
    
    public static function deleteComments($data)
    {
        self::destroy($data);
        return ["data"=>""];
    }
    
    public static function queryComments($data)
    {
//        pass
    }
}