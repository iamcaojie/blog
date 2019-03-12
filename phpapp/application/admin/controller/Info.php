<?php
namespace app\admin\controller;

use app\admin\model\Info as Infomodel;

// 每个方法为同名模型的函数

class Info extends Base
{
    // 获取所有网站信息
    // /admin/info/getinfolist
    public function getInfoList()
    {
        $data = Infomodel::getInfoList();
        return json(["code"=>0, "msg"=>"查询成功", "data"=>$data]);
    }
    
    // 创建网站信息
    // /admin/info/createinfo
    public function createInfo()
    {
        $data = input('post.');
        // 验证数据合法性
        $data = Infomodel::createInfo($data);
        return json(["code"=>0,"msg"=>"创建网站信息成功"]);
    }
    
    // 编辑网站信息
    // /admin/info/editinfo
    public function editInfo()
    {
        $data = input('post.');
        // 验证数据合法性
        $data = Infomodel::editInfo($data);
        return json(["code"=>0,"msg"=>"编辑网站信息成功"]);
    }
    
    // 查询网站信息
    public function queryInfo()
    {
        //pass
    }
    
    // 删除网站信息
    // /admin/info/deleteinfo
    public function deleteInfo()
    {
        $data = input('post.');
        // 验证数据合法性
        $data = Infomodel::deleteInfo($data);
        return json(["code"=>0,"msg"=>"删除网站信息成功"]);
    }

}