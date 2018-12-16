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
        }else{
            $bloglist = [];
            $pagelist = $this -> where('delete_time',null) -> limit(($page-1)*$limit,$page*$limit) -> select();
            // 查询原始分类数据 查询原始标签数据 添加操作数据 
            foreach ($pagelist as $value){
                $value['cate'] = self::get($value['id']) -> cate-> blog_category;
                $tag = [];
                foreach(self::get($value['id']) -> tags as $temp)
                {
                    array_push($tag, $temp['tag']);
                }
                $value['tag'] = $tag;
                $value["operate"]='<a >查看 </a><a class="editBlog" onclick="editBlog('.$value -> id.')">修改 </a><a class="deteteBlog" onclick="deleteBlog('.$value -> id.')">删除</a>';
                array_push($bloglist,$value);
            }
            return $bloglist;
        }
    }
    // 总页数
    public function getPageCount($page,$limit)
    {
        $count = $this -> where('delete_time',null) -> count();
        return ceil($count/$limit);
    }
}