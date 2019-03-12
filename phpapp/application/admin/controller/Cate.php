<?php
namespace app\admin\controller;

use app\admin\model\Cate as Catemodel;

// 每个方法为同名模型的函数

class Cate extends Base
{
    protected $cate;
    protected $count;

    function _initialize()
    {
        parent::_initialize();
        $data = Catemodel::getCateList();
        foreach ($data as $k=>$v){
            $this->cate[$v['id']] = $v['blog_category'];
        }
        $this->cate[0] = '顶级分类';
        $this->count = count($this->cate);
    }

    // 分类管理调用列表
    public function index()
    {
        $data = Catemodel::getCateTree();
        return view('cate/cate',['cates'=>$data]);
    }
    // 获取所有分类
    public function getCateList()
    {
        $data = Catemodel::getCateList();
        return json(["code"=>0, "msg"=>"查询成功", "data"=>$data]);
    }
    // 排序显示所有分类
    public function getCateTreeList($page=1,$limit=10)
    {
        $data = Catemodel::getCateTree();
        foreach($data as $k=>$v){
            // 添加分级前缀，便于前端显示
            $v['blog_category'] = str_repeat('-',$v['level']).$v['blog_category'];
            // 获取pid的分类名称
            $v['pid_name'] = $this->cate[$v['pid']];
        }
        // 按页码截断数组,分页显示
        $data = array_slice($data,($page-1)*$limit,$limit);
        return json(["code"=>0, "msg"=>"查询成功", "count"=>$this->count,"data"=>$data]);
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
    // public function queryCate()
    // {
        // pass
    // }
    
    // 删除分类
    // 已有博客的重置为默认分类
    // 同时删除分类的所有子类
    // /admin/cate/deletecate
    public function deleteCate()
    {
        $data = input('post.');
        // 验证数据合法性
        $data = Catemodel::deleteCate($data);
        return json(["code"=>0,"msg"=>"删除分类成功"]);
    }

}