<?php 
namespace app\admin\model;

use think\Model;

// update_time格式在database中设置
// layui数据规范{"code":0,"msg":"","count":7,"data":[]}
// 0:正常; 1:参数错误; 2:查询错误; 3:未知错误
// 生成json的数组属性名必须双引号

class Blog extends Model
{
    
    // 相对与分类的一对多关联
    public function cate()
    {
        return $this->belongsTo('cate','cate_id');
    }
    
    // 标签与博客多对多关联
    public function tags()
    {
        return $this->belongsToMany('tags','think_blogs_tags','tag_id','blog_id');
    }
    
    // 博客与评论一对多关联
    public function comments()
    {
        return $this->hasMany('comments',' ','tag_id');
    }
    
    // 获取博客列表
    public function getBlogList($page,$limit)
    {
        $bloglist = [];
        $pagelist = $this -> where('delete_time',null) -> limit(($page-1)*$limit,$page*$limit) -> select();
        $blogcount = $this -> where('delete_time',null) -> count();

        // 查询分类数据 查询标签数据 添加操作数据 
        foreach ($pagelist as $value){
            $value['cate'] = self::get($value['id']) -> cate() -> cate;
            $value['tag'] = self::get($value['id']) -> tags;
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
    // 不删除评论
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