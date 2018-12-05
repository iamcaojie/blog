<?php 
namespace app\blog\model;

use think\Model;

class Page extends Model
{
    protected $table = 'think_blog';
    // 分页列表数据
    public function getBlogList($page,$page_num)
    {
        $bloglist = [];
        $pagelist = $this->where('id','BETWEEN',[($page-1)*$page_num,$page*$page_num])->select();
        foreach ($pagelist as $value){
            $bloglist[$value -> blog_title] = $value -> blog_text;
        }
        return $bloglist;
    }
    // 总页数
    public function getPageCount($page,$page_num)
    {
        $count = $this->count();
        return ceil($count/$page_num);
    }
}