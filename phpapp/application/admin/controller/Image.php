<?php
namespace app\admin\controller;

use app\admin\model\Image as ImageModel;

class Image extends Base
{
    public function index()
    {
        // 获取所有图片（轮播，主图，详情图，头像）
        $bannerImage = ImageModel::getImageList(1);
        $masterImage = ImageModel::getImageList(2);
        $detailImage = ImageModel::getImageList(3);
        $avatarImage = ImageModel::getImageList(4);
        return view('image/image',
            ['bannerData'=>$bannerImage,
            'masterData'=>$masterImage,
            'detailData'=>$detailImage,
            'avatarData'=>$avatarImage]
        );
    }
    
    // 删除图片
    public function deleteImage()
    {
        $id = input('post.')['id'];
        $info = Imagemodel::deleteImage($id);
        if($info){
            return json(["code"=>0,"msg"=>"删除图片成功"]);
        }
    }
}