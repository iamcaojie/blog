<?php
namespace app\admin\controller;

use app\admin\model\Image as Imagemodel;

// 每个方法为同名模型的函数

class Image
{
    // 获取所有图片
    // /admin/image/getimagelist
    public function getImageList($page,$limit)
    {
        return json(Imagemodel::getImageList($page,$limit));
    }

    // 编辑图片
    // /admin/image/editimage
    public function editImage()
    {
        $data = input('post.');
        // 验证数据合法性
        $data = Imagemodel::editImage($data);
        return json(["code"=>0,"msg"=>"编辑图片成功"]);
    }
    
    // 查询图片
    public function queryImage()
    {
        //pass
    }
    
    // 删除图片
    // /admin/image/deleteimage
    public function deleteImage()
    {
        $data = input('post.');
        // 验证数据合法性
        $data = Imagemodel::deleteImage($data);
        return json(["code"=>0,"msg"=>"删除图片成功"]);
    }

}