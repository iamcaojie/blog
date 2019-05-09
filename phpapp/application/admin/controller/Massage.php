<?php
namespace app\admin\controller;

use app\admin\model\Massage as Massagemodel;

// 每个方法为同名模型的函数

class Massage extends Base
{
    // 获取所有留言消息
    // /admin/massage/getmassagelist
    public function getMassageList($page,$limit)
    {
        return json(Massagemodel::getMassageList($page,$limit));
    }
    
    // 创建留言消息
    public function createMassage()
    {
        $data = input('post.');
        // 验证数据合法性
        $data = Massagemodel::createMassage($data);
        return json(["code"=>0,"msg"=>"创建留言消息成功"]);
    }
    
    // 编辑留言消息
    // /admin/massage/editmassage
    public function editMassage()
    {
        $data = input('post.');
        // 验证数据合法性
        $data = Massagemodel::editMassage($data);
        return json(["code"=>0,"msg"=>"编辑留言消息成功"]);
    }
    
    // 查询留言消息
    public function queryMassage()
    {
        //pass
    }
    
    // 删除留言消息
    // 已有博客的重置为默认留言消息
    // /admin/massage/deletemassage
    public function deleteMassage()
    {
        $data = input('post.');
        // 验证数据合法性
        $data = Massagemodel::deleteMassage($data);
        return json(["code"=>0,"msg"=>"删除留言消息成功"]);
    }

}