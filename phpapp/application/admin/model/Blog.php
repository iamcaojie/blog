<?php 
namespace app\admin\model;

use think\Model;

class Blog extends Model
{
    // public function getBlogList($)
    // {
        
    // }
    // public function createBlog()
    // {
        
    // }
    // public function deleteBlog($id)
    // {
        
    // }    
    // public function editBlog()
    // {
        
    // }    
    public function queryBlog($id)
    {
        $queryblog = [];
        $blog = $this->where('id',$id)->find();
        array_push($queryblog,[$blog -> blog_title, $blog -> blog_text]);
        return $queryblog;
    }
}