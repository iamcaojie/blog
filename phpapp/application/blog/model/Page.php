<?php 
namespace app\blog\model;

use think\Model;

class Page extends Model
{
    protected $table = 'think_blog';
    // 分页列表数据
    public function getBlogList($page,$limit)
    {
        if (($page > $this->getPageCount($page,$limit)) or ($page<1)){
            return '错误';
        }else
        {
        $bloglist = [];
        $pagelist = $this->where('id','>=',($page-1)*$limit+1)->limit($limit)->select();
        foreach ($pagelist as $value){
            array_push($bloglist,[$value -> blog_title,$value -> blog_text]);
        }
        return $bloglist;
        }
    }
    // 总页数
    public function getPageCount($page,$limit)
    {
        $count = $this->count();
        return ceil($count/$limit);
    }
}