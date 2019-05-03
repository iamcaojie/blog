<?php
namespace app\blog\controller;

use think\Controller;
use think\Cache;
use app\admin\model\Cate as CateModel;
use app\admin\model\Web as WebModel;
class Base extends Controller 
{
    public function _initialize()
    {
        // 判断网站是否开启
        $web = WebModel::get(1);
        if(!$web['web_status']){
            echo $web['close_info'];
            die;
        }
        // 初始化页面数据
        $this->getLoginName();
        $this->getNavCates();
        $this->getWebData();
        $this->getAllCate();
        // 过滤输入数据
    }

    // 导入配置
    public function getConf()
    {
        // 是否开启网站

    }
    // 获取当前登录用户
    public function getLoginName()
    {
        $nickName = session('user')['nickname'];
        $this->assign("nickname",$nickName);
        $userName = session('user')['username'];
        $this->assign("username",$userName);
    }
    // 获取导航数据
    public function getNavCates()
    {
        $navData = CateModel::queryNav();
        $this->assign('nav',$navData);
    }
    // 获取网站数据
    public function getWebData()
    {
        $webData = WebModel::get(1);
        $this->assign('webdata',$webData);
    }
    // 获取所有导航数据
    public function getAllCate()
    {
        $cateData = Catemodel::getCateList();
        $this->assign('cates',$cateData);
    }
    // 获取当前位置
    public function getLocation()
    {

    }
    // redis缓存，在配置文件中进行配置
    public function cache()
    {
        Cache::connect();
    }
}