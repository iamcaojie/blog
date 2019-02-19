<?php
namespace app\admin\controller;

use app\admin\model\Doclinks as Doclinksmodel;

class Doclinks
{
    // 获取所有文档链接
    // /admin/doclinks/getdoclinkslist
    public function getDoclinksList()
    {
        $data = Doclinksmodel::getDoclinksList();
        return json(["code"=>0, "msg"=>"查询成功", "data"=>$data]);
    }
    
    // 创建文档链接
    // /admin/doclinks/createdoclinks
    public function createDoclinks()
    {
        $data = input('post.');
        // 验证数据合法性
        $data = Doclinksmodel::createCate($data);
        return json(["code"=>0,"msg"=>"创建文档链接成功"]);
    }
    
    // 编辑文档链接
    // /admin/doclinks/editdoclinks
    public function editDoclinks()
    {
        $data = input('post.');
        // 验证数据合法性
        $data = Doclinksmodel::editDoclinks($data);
        return json(["code"=>0,"msg"=>"编辑评论成功"]);
    }
    
    // 查询文档链接
    public function queryDoclinks()
    {
        //pass
    }
    
    // 删除文档链接
    // /admin/doclinks/deletedoclinks
    public function deleteDoclinks()
    {
        $data = input('post.');
        // 验证数据合法性
        $data = Doclinksmodel::deleteDoclinks($data);
        return json(["code"=>0,"msg"=>"删除文档链接成功"]);
    }
}