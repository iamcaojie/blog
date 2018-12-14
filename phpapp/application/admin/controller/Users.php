<?php
namespace app\admin\controller;

use app\admin\model\Users as Usersmodel;

// 每个方法为同名模型的函数

class Users
{
    // 获取所有用户
    // /admin/users/getuserslist
    public function getUsersList()
    {
        $data = Usersmodel::getUsersList();
        return json(["code"=>0, "msg"=>"查询成功", "data"=>$data]);
    }
    
    // 创建用户
    // /admin/users/createusers
    public function createUsers()
    {
        $data = input('post.');
        // 验证数据合法性
        $data = Usersmodel::createUsers($data);
        return json(["code"=>0,"msg"=>"创建用户成功"]);
    }
    
    // 编辑用户
    // /admin/users/editusers
    public function editUsers()
    {
        $data = input('post.');
        // 验证数据合法性
        $data = Usersmodel::editUsers($data);
        return json(["code"=>0,"msg"=>"编辑用户成功"]);
    }
    
    // 查询用户
    public function queryUsers()
    {
        //pass
    }
    
    // 删除用户
    // 已有博客的重置为默认用户
    // /admin/users/deleteusers
    public function deleteUsers()
    {
        $data = input('post.');
        // 验证数据合法性
        $data = Usersmodel::deleteUsers($data);
        return json(["code"=>0,"msg"=>"删除用户成功"]);
    }

}