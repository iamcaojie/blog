<?php 
namespace app\admin\model;

use think\Model;

// update_time在database中设置
// layui数据规范{"code":0,"msg":"","count":7,"data":[]}
// 0:正常; 1:参数错误; 2:查询错误; 3:未知错误
// 属性名必须双引号

class Blog extends Model
{
    protected $type = [
        // 'delete_time'    =>  'datetime',
    ];
    
    public function getBlogList($page,$limit)
    {
        $bloglist = [];
        $pagelist = $this ->where('id','>=',($page-1)*$limit+1) -> limit($limit) -> select();
        $blogcount = $this -> count();
        // -> where('delete_time',null) bug
        // 添加操作数据
        foreach ($pagelist as $value){
            $value["operate"]='<a >查看 </a><a class="editBlog" onclick="editBlog('.$value -> id.')">修改 </a><a class="deteteBlog" onclick="deleteBlog('.$value -> id.')">删除</a>';
            array_push($bloglist,$value);
        }
        return ["code"=>0,"msg"=>"列表查询完成","count"=>$blogcount,"data"=>$bloglist];
    }
    
    public function createBlog()
    {
        // pass
    }
    
    // 只标记删除，记录delete_time,int类型
    public function deleteBlog($id)
    {
        $deleteblogitem = $this::get($id);
        $deleteblogitem -> delete_time = strtotime('now');
        $deleteblogitem -> save();
        return ["code"=>0,"msg"=>"删除成功"];
    }   
    
    public function editBlog()
    {
        // pass
    }    
    
    public function queryBlog($id)
    {
        $blog = $this->where('id',$id)->find();
        return ["code"=>0,"msg"=>"查询完成","data"=>$blog];
    }
}