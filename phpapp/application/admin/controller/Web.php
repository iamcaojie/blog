<?php
namespace app\admin\controller;

use app\admin\model\Web as Webmodel;


// 每个方法为同名模型的函数

class Web
{
    // 获取所有网站状态
    // /admin/web/getweblist
    public function getWebList()
    {
        $data = Webmodel::getWebList();
        return json(["code"=>0, "msg"=>"查询成功", "data"=>$data]);
    }
    
    // 创建网站状态
    // /admin/web/createweb
    public function createWeb()
    {
        $data = input('post.');
        // 验证数据合法性
        $data = Webmodel::createWeb($data);
        return json(["code"=>0,"msg"=>"创建网站状态成功"]);
    }
    
    // 编辑网站状态
    // /admin/web/editweb
    public function editWeb()
    {
        $data = input('post.');
        // 验证数据合法性
        $data = Webmodel::editWeb($data);
        return json(["code"=>0,"msg"=>"编辑网站状态成功"]);
    }
    
    // 查询网站状态
    public function queryWeb()
    {
        //pass
    }
    
    // 删除网站状态
    // 已有博客的重置为默认网站状态
    // /admin/web/deleteweb
    public function deleteWeb()
    {
        $data = input('post.');
        // 验证数据合法性
        $data = Webmodel::deleteWeb($data);
        return json(["code"=>0,"msg"=>"删除网站状态成功"]);
    }

}