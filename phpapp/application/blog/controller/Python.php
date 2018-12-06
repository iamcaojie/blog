<?php
namespace app\blog\controller;

use think\View;
use app\blog\model\Page;
class Python
{
    public function index($page=1,$page_num=10)
    {
        $pagel =new Page;
        $bloglist = $pagel->getBlogList($page,$page_num);
        $pagecount = $pagel->getPageCount($page,$page_num);
        // print_r($bloglist);
        // print_r($pagecount);
        
        $view = new View();
        return $view->fetch("contents/contents",['bloglist'=>$bloglist,$pagecount]);
    }
    public function detail($id=1)
    {
        
        $view = new View();
        return $view->fetch("detail/detail");
    }
}
