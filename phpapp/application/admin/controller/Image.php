<?php
namespace app\admin\controller;

use app\admin\model\Image as ImageModel;

class Image extends Base
{
    public function index()
    {
        // 获取所有图片（轮播，主图，详情图）
    }
        // 获取所有图片
    public function getImageList($page,$limit)
    {
        return json(Imagemodel::getImageList($page,$limit));
    }

    // 编辑图片
    // /admin/image/editimage
    public function editImage()
    {
        $data = input('post.');
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