<?php
namespace app\blog\controller;

use app\admin\model\Massage as MassageModel;
use app\admin\model\Image as ImageModel;
use app\admin\model\Blog as BlogModel;
use app\admin\model\Links as LinkModel;
use app\admin\model\Follow as FollowModel;

class Index extends Base
{
    public function index()
    {
        // 获取轮播图
        $bannerImageData = ImageModel::getBannerImage();
        $this->assign('bannerImagesData',$bannerImageData);
        // 获取最近更新
        $lastUpdateData = BlogModel::getLastUpdate(10);
        $this->assign('lastUpdateData',$lastUpdateData);
        // 获取点击排行
        $blogRankData = BlogModel::getBlogRank(10);
        $this->assign('blogRankData',$blogRankData);
        // 获取标签聚合
        $tagData = BlogModel::getTag();
        $this->assign('tagData',$tagData);
        // 获取实用网站，友情链接
        $linkData = LinkModel::getLink(3);
        $this->assign('linkData',$linkData);
        // 是否签到
        $this->assign('checkInData',cookie('msgData'));
        // 获取访问者和我的关系
        $userId = session('user')['id'];
        if(isset($userId)){
            $btnText = FollowModel::queryStatus($userId,1);
            $this ->assign('btnTextData',$btnText);
        }else{
            $this ->assign('btnTextData','加关注');
        }
        // redis统计
        // pass
        return view("blog/blog");
    }

    // 获取留言
    public function getMassage()
    {
        $massage = new MassageModel;
        $data = input('post.');
        $massage -> massage_title = htmlentities($data['massage_title']);
        $massage -> contact = htmlentities($data['contact']);
        $massage -> massage_text = htmlentities($data['massage_text']);
        $info = $massage -> save();
        if($info){
            return ["code"=>0, "msg"=>"留言已提交"];
        }else{
            return ["code"=>-1, "msg"=>"留言失败"];
        }
    }

    // ajax无刷新操作
    public function getMore()
    {

    }
}
