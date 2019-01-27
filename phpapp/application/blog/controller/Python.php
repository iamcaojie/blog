<?php
namespace app\blog\controller;

use think\View;
// use app\blog\model\Page;
use app\admin\model\Blog as Blogmodel;
use app\admin\model\Comments as Commentsmodel;


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
        $blogComment = Commentsmodel::queryComments($id);
        $view = new View();
        return $view->fetch("detail/detail",['id'=>$id,'blogdetail'=>$detail['data'],'blogcomments'=>$blogComment['data']]);
    }
    public function comment()
    {
        $data = input("post.");
//        验证数据合法性
        $data["comment_text"] = htmlentities($data["comment_text"]);
        return json(Commentsmodel::createComments($data));
    }
    public function getcomments()
    {
        
    }
}
