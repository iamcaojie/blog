<?php 
namespace app\admin\model;

use think\Model;


class Image extends Model
{
    protected static function formatImage($data)
    {
        $imageCateData = db('imagecate')->column('dir','id');
        foreach ($data as $key => $value)
        {
            $value['image_url'] = '/uploads/'.$imageCateData[$value['imagecate_id']].'/'.$value['address'].'.'.$value['ext'];
        }
        return $data;
    }
    // 获取图片列表
    public static function getImageList($imageCate)
    {
        $imageList = self::where('imagecate_id',$imageCate)->select();
        $imageList = self::formatImage($imageList);
        return $imageList;
    }

    // 编辑图片
    public static function editImage($data)
    {
        self::update($data);
        return ["data"=>""];
    }

    // 删除图片
    public static function deleteImage($id)
    {
        $info = self::destroy(['id'=>$id]);
        return $info;
    }

    // 查询图片
    public static function queryImage($data)
    {
        //pass
    }

    // 获取轮播图
    public static function getBannerImage()
    {
        return self::where('imagecate_id',1)
            -> field('address,ext')
            -> select();
    }
}
