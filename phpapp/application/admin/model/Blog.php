<?php 
namespace app\admin\model;

use think\Model;
//update_time在database中设置
class Blog extends Model
{

    public function getBlogList($page,$limit)
    {
        // if (($page > $this->getPageCount($page,$limit)) or ($page<1)){
            // return '错误';
        // }else
        // {
        $pagelist = $this->where('id','>=',($page-1)*$limit+1)->limit($limit)->select();
        $blogcount = $this->count();
        // foreach ($pagelist as $value){
            // array_push($bloglist,[$value -> blog_title,$value -> blog_text]);
        // }
        return ["code"=>0,"msg"=>"","count"=>$blogcount,'data'=>$pagelist];
        // }
    }
    public function createBlog()
    {
        
    }
    // 只标记删除，记录delete_time,int类型
    public function deleteBlog($id)
    {
        $deleteblogitem = $this::get($id);
        $deleteblogitem -> delete_time = strtotime('now');
        $deleteblogitem -> save();
        // return $deleteblogitem -> delete_time;
    }    
    public function editBlog()
    {
        
    }    
    public function queryBlog($id)
    {
        $blog = $this->where('id',$id)->find();
        // array_push($queryblog,[$blog -> blog_title, $blog -> blog_text]);
        return $blog;
    }
}