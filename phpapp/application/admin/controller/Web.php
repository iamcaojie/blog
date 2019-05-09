<?php
namespace app\admin\controller;

use app\admin\model\Web as Webmodel;

// 每个方法为同名模型的函数

class Web extends Base
{
    // 显示系统设置
    public function index()
    {
        return view('web/web');
    }

    // 获取所有系统设置
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

    // 编辑网站信息
    public function editWeb()
    {
        $data = input('post.');
        // 验证数据合法性
        $info = Webmodel::editWeb($data);
        if($info){
            return json(["code"=>0,"msg"=>"网站信息编辑成功"]);
        }else{
            return json(["code"=>-1,"msg"=>"网站信息编辑失败"]);
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