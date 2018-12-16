<?php
namespace app\blog\controller;

use think\View;
// use app\blog\model\Page;
use app\admin\model\Blog as Blogmodel;
use app\blog\model\Detail;
class Python
{
    public function index($page=1,$limit=10)
    {
        $bloglist = Blogmodel::getBlogList($page,$limit);
        $view = new View();
        return $view->fetch("contents/contents",['bloglist'=>$bloglist['data'],'pagecount'=>$bloglist['count']]);
    }
    public function detail($id)
    {
        $detail = Blogmodel::queryBlog($id);
        $view = new View();
        return $view->fetch("detail/detail",['blogdetail'=>$detail['data']]);
    }
}
