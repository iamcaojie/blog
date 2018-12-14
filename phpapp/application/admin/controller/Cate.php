<?php
namespace app\admin\controller;

use app\admin\model\Cate as Catemodel;

// 每个方法为同名模型的函数

class Cate
{
    // 获取所有分类
    // /admin/cate/getcatelist
    public function getCateList()
    {
        $data = Catemodel::getCateList();
        return json(["code"=>0, "msg"=>"查询成功", "data"=>$data]);
    }
    
    // 创建分类
    // /admin/cate/createcate
    public function createCate()
    {
        $data = input('post.');
        // 验证数据合法性
        $data = Catemodel::createCate($data);
        return json(["code"=>0,"msg"=>"创建分类成功"]);
    }
    
    // 编辑分类
    // /admin/cate/editcate
    public function editCate()
    {
        $data = input('post.');
        // 验证数据合法性
        $data = Catemodel::editCate($data);
        return json(["code"=>0,"msg"=>"编辑分类成功"]);
    }
    
    // 查询分类
    public function queryCate()
    {
        //pass
    }
    
    // 删除分类
    // 已有博客的重置为默认分类
    // /admin/cate/deletecate
    public function deleteCate()
    {
        $data = input('post.');
        // 验证数据合法性
        $data = Catemodel::deleteCate($data);
        return json(["code"=>0,"msg"=>"删除分类成功"]);
    }

}