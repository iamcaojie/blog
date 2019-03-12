<?php
namespace app\admin\controller;

use app\admin\model\Links as Linksmodel;

// 每个方法为同名模型的函数

class Links extends Base
{
    // 获取所有链接
    // /admin/inks/getlinkslist
    public function getLinksList($page=1,$limit=10)
    {
        $data = Linksmodel::getLinksList($page,$limit);
        return json(["code"=>0,
            "msg"=>"列表查询完成",
            "count"=>$data['count'],
            'data'=>$data['data']
        ]);
    }
    
    // 创建链接
    // /admin/links/createlinks
    public function createLinks()
    {
        $data = input('post.');
        // 验证数据合法性
        $data = Linksmodel::createLinks($data);
        return json(["code"=>0,"msg"=>"创建链接成功"]);
    }
    
    // 编辑链接
    // /admin/links/editlinks
    public function editLinks()
    {
        $data = input('post.');
        // 验证数据合法性
        $data = Linksmodel::editLinks($data);
        return json(["code"=>0,"msg"=>"编辑链接成功"]);
    }
    
    // 查询链接
    public function querylink($id)
    {
        $data = Linksmodel::queryLink($id);
        return json(['code'=>0, 'msg'=>'查询完成','data'=> $data]);
    }
    
    // 删除链接
    // /admin/links/deletelink
    public function deleteLink()
    {
        $data = input('post.');
        // 验证数据合法性
        $info = Linksmodel::deletelink($data);
        if($info){
            return json(["code"=>0,"msg"=>"删除链接成功",'data'=>$info]);
        }else{
            return json(["code"=>-1,"msg"=>"删除链接失败",'data'=>$info]);
        }

    }

}