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

    // 网站状态修改
    public function webStatus()
    {
        $data = input('post.');
        Webmodel::where('id', '1')
            ->where('name', 'blog')
            ->update(['web_status' => $data['web_status']]);
        if (Webmodel::get(1)->web_status) {
            return json(["code" => 0, "msg" => "网站已开启"]);
        } else {
            return json(["code" => 0, "msg" => "网站已关闭"]);
        }
    }
    // 创建网站状态
    // /admin/web/createweb
//    public function createWeb()
//    {
//        $data = input('post.');
//        // 验证数据合法性
//        $data = Webmodel::createWeb($data);
//        return json(["code"=>0,"msg"=>"创建网站状态成功"]);
//    }

    // 编辑网站信息
    // /admin/web/editweb
    public function editWeb()
    {
        $data = input('post.');
        // 验证数据合法性
        $info = Webmodel::editWeb($data);
        if($info){
            return json(["code"=>0,"msg"=>"编辑成功"]);
        }else{
            return json(["code"=>-1,"msg"=>"编辑失败"]);
        }

    }

    // 查询网站状态
//    public function queryWeb()
//    {
//        //pass
//    }
    
    // 删除网站状态
    // 已有博客的重置为默认网站状态
    // /admin/web/deleteweb
//    public function deleteWeb()
//    {
//        $data = input('post.');
//        // 验证数据合法性
//        $data = Webmodel::deleteWeb($data);
//        return json(["code"=>0,"msg"=>"删除网站状态成功"]);
//    }

}