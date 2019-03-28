<?php
namespace app\blog\controller;

use app\admin\model\Massage as MassageModel;
use app\admin\model\Image as ImageModel;
use app\admin\model\Blog as BlogModel;

class Index extends Base
{
    public function index()
    {
        // 获取轮播图
        $bannerImageData = ImageModel::getBannerImage();
        $this->assign('bannerImages',$bannerImageData);
        // 获取最近更新
        $lastUpdateData = BlogModel::getLastUpdate();
        $this->assign('lastUpdateData',$lastUpdateData);
        // 获取点击排行

        // 获取标签聚合

        return view("blog/blog");
    }
    
    public function getMassage()
    {
        $massage = new MassageModel;
        $data = input('post.');
        $massage -> massage_title = $data['massage_title'];
        $massage -> contact = $data['contact'];
        $massage -> massage_text = $data['massage_text'];
        $info = $massage -> save();
        if($info){
            return ["code"=>0, "msg"=>"提交成功"];
        }else{
            return ["code"=>-1, "msg"=>"提交失败"];
        }

    }
}
