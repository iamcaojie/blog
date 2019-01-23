<?php
namespace app\admin\controller;

use app\admin\model\Weblinks as Weblinksmodel;

// 每个方法为同名模型的函数

class Weblinks
{
    // 获取所有外站链接
    // /admin/weblinks/getweblinkslist
    public function getWeblinksList()
    {
        $data = Weblinksmodel::getWeblinksList();
        return json(["code"=>0, "msg"=>"查询成功", "data"=>$data]);
    }
    
    // 创建外站链接
    // /admin/weblinks/createweblinks
    public function createWeblinks()
    {
        $data = input('post.');
        // 验证数据合法性
        $data = Weblinksmodel::createWeblinks($data);
        return json(["code"=>0,"msg"=>"创建外站链接成功"]);
    }
    
    // 编辑外站链接
    // /admin/weblinks/editweblinks
    public function editWeblinks()
    {
        $data = input('post.');
        // 验证数据合法性
        $data = Weblinksmodel::editsWeblinks($data);
        return json(["code"=>0,"msg"=>"编辑外站链接成功"]);
    }
    
    // 查询外站链接
    public function queryWeblinks()
    {
        //pass
    }
    
    // 删除外站链接
    // 已有博客的重置为默认外站链接
    // /admin/weblinks/deleteweblinks
    public function deleteWeblinks()
    {
        $data = input('post.');
        // 验证数据合法性
        $data = Weblinksmodel::deleteWeblinks($data);
        return json(["code"=>0,"msg"=>"删除外站链接成功"]);
    }

}