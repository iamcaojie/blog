<?php
namespace app\admin\controller;

use app\admin\model\Downloads as DownloadsModel;

// 每个方法为同名模型的函数

class Downloads extends Base
{
    // 获取所有下载链接
    // /admin/downloads/getdownloadslist
    public function getDownloadsList()
    {
        $data = Downloadsmodel::getDownloadsList();
        return json(["code"=>0, "msg"=>"查询成功", "data"=>$data]);
    }
    
    // 创建下载链接
    // /admin/downloads/createdownloads
    public function createDownloads()
    {
        $data = input('post.');
        // 验证数据合法性
        $data = Downloadsmodel::createDownloads($data);
        return json(["code"=>0,"msg"=>"创建下载链接成功"]);
    }
    
    // 编辑下载链接
    // /admin/downloads/editdownloads
    public function editDownloads()
    {
        $data = input('post.');
        // 验证数据合法性
        $data = Downloadsmodel::editsDownloads($data);
        return json(["code"=>0,"msg"=>"编辑下载链接成功"]);
    }
    
    // 删除下载链接
    // /admin/downloads/deletedownloads
    public function deleteDownloads()
    {
        $data = input('post.');
        // 验证数据合法性
        $data = Downloadsmodel::deleteDownloads($data);
        return json(["code"=>0,"msg"=>"删除下载链接成功"]);
    }

}