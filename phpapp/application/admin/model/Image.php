<?php 
namespace app\admin\model;

use think\Model;


class Image extends Model
{
    // sql:select * from _image;
    public static function getImageList($page,$limit)
    {
        $list = self::where('delete_time',null) -> limit(($page-1)*$limit,$limit) -> select();
        $count = self::where('delete_time',null) -> count();
        return ["code"=>0,"msg"=>"列表查询完成","count"=>$count,"data"=>$list];
    }
    
    public static function editImage($data)
    {
        self::update($data);
        return ["data"=>""];
    }
    
    public static function deleteImage($data)
    {
        self::destroy($data);
        return ["data"=>""];
    }
    
    public static function queryImage($data)
    {
        //pass
    }

    // 获取轮播图
    public static function getBannerImage()
    {
        return self::where('imagecate_id',1)
            ->field('address,ext')
            -> select();
    }
}
