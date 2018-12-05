<?php
namespace app\blog\controller;

use think\View;
use app\blog\model\Page;
class Python
{
    public function index($page=1,$page_num=3)
    {
        $pagea =new Page;
        $bloglist = $pagea->getBlogList($page,$page_num);
        $pagecount = $pagea->getPageCount($page,$page_num);
        print_r($bloglist);
        print_r($pagecount);
        
        // $view = new View();
        // return $view->fetch("contents/contents");
    }
    public function detail($id=1)
    {
        
        $view = new View();
        return $view->fetch("detail/detail");
    }
}
