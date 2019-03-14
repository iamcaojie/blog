<?php
namespace app\admin\controller;

use app\admin\model\Cate as Catemodel;
use app\admin\model\Blog as Blogmodel;

class Cate extends Base
{
    protected $cate;
    protected $count;
    protected $beforeActionList = [
        'checkid'  =>
            ['only'=>'signdeletecate,deletecate,createcate,editcate'],
    ];

    function _initialize()
    {
        parent::_initialize();
        $data = Catemodel::getCateList();
        foreach ($data as $k=>$v){
            $this->cate[$v['id']] = $v['blog_category'];
        }
        $this->cate[0] = '顶级分类';
        $this->count = count($this->cate)-1;
    }

    public function checkid()
    {
        if(isset(input('post.')['id'])&&(input('post.')['id']<=1)){
            json(['code'=>-1,'msg'=>'默认分类无法修改或删除'])->send();die;
        }
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
            $v['p_blog_category'] = str_repeat('-',$v['level']).$v['blog_category'];
            // 获取pid的分类名称
            $v['pid_name'] = $this->cate[$v['pid']];
        }
        // 按页码截断数组,分页显示
        $data = array_slice($data,($page-1)*$limit,$limit);
        return json(["code"=>0, "msg"=>"查询成功", "count"=>$this->count,"data"=>$data]);
    }
    // 创建分类，非ajax提交
    // /admin/cate/createcate
    public function createcate()
    {
        $data = input('post.');

        $info = Catemodel::createCate($data);
        if($info){
            // return json(["code"=>0,"msg"=>"创建分类成功"]);
            return $this->redirect('/admin/cate');
        }else {
            return '<span style="color:red;">系统错误 </span><a href="/admin/cate">点击返回</a>';
        }
    }

    
    // 编辑分类
    // /admin/cate/editcate
    public function editcate()
    {
        $data = input('post.');
        $info = Catemodel::editCate($data);
        return json(["code"=>0,"msg"=>"编辑分类成功"]);
    }
    // 标记删除
    public function signdeletecate()
    {
        $id = input('post.')['id'];
        $cate = new Catemodel();
        $delArrList = [['id'=>$id,'delete_time'=>strtotime('now')]];
        $pDelArr = $cate -> getChildrenId($id);
        foreach ($pDelArr as $k=>$v){
            $delArrList[] = ['id'=>$v,'delete_time'=>strtotime('now')];
        }
        $info = $cate->saveAll($delArrList);
        if($info){
            return json(["code"=>0,"msg"=>"分类已隐藏"]);
        }
    }

    // 删除分类
    // /admin/cate/deletecate
    public function deletecate()
    {
        // 判断子分类是否存在，存在则不允许删除，不存在则允许删除
        $id = input('post.')['id'];
        $cate = new Catemodel();
        $pDelArr = $cate -> getChildrenId($id);
        $pDelArr[] = $id;
        if(count($pDelArr)<=1){
            // 相关博客的重置为默认分类
            $pEditBlogData = Blogmodel::where('cate_id',$id)->select();
            foreach ($pEditBlogData as $k=>$v){
                Blogmodel::update(['id' => $v['id'], 'cate_id' => 1]);
            }
            $info = Catemodel::destroy($pDelArr);
            if($info){
                return json(["code"=>0,"msg"=>"删除分类成功"]);
            }
        }else{
            return json(["code"=>-1,"msg"=>"请先删除下级分类"]);
        }
    }

    // 恢复全部隐藏的分类
    public function recover(){
        $data = Catemodel::where('delete_time','not null')->select();
        $cate = new Catemodel();
        $pCoverArr = [];
        foreach ($data as $k=>$v){
            $pCoverArr[] = ['id'=>$v['id'],'delete_time'=>NULL];
        }
        $info = $cate->saveAll($pCoverArr);
        if($info){
            return json(['code'=>0, 'msg'=>count($info).'个隐藏分类已显示']);
        }else{
            return json(['code'=>-1, 'msg'=>'无隐藏分类']);
        }
    }
}