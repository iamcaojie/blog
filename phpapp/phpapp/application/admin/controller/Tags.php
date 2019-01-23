<?php
namespace app\admin\controller;

use app\admin\model\Tags as Tagsmodel;

class Tags
{
    // 获取所有标签
    // /admin/tags/gettagslist
    public function getTagsList()
    {
        $data = Tagsmodel::getTagsList();
        return json(["code"=>0, "msg"=>"查询成功", "data"=>$data]);
    }
    
    // 创建标签
    // /admin/tags/createtags
    public function createTags()
    {
        $data = input('post.');
        // 验证数据合法性
        $data = Tagsmodel::createTags($data);
        return json(["code"=>0,"msg"=>"创建标签成功"]);
    }
    
    // 编辑标签
    // /admin/tags/edittags
    public function editTags()
    {
        $data = input('post.');
        // 验证数据合法性
        $data = Tagsmodel::editTags($data);
        return json(["code"=>0,"msg"=>"编辑标签成功"]);
    }
    
    // 查询标签
    public function queryTags()
    {
        //pass
    }
    
    // 删除标签
    // 已有博客的重置为默认标签
    // /admin/tags/deletetags
    public function deleteTags()
    {
        $data = input('post.');
        // 验证数据合法性
        $data = Tagsmodel::deleteTags($data);
        return json(["code"=>0,"msg"=>"删除标签成功"]);
    }

}