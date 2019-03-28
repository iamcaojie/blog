<?php
namespace app\blog\controller;
use app\admin\model\Web as Webmodel;
use app\admin\model\Blog as Blogmodel;
use app\admin\model\Cate as Catemodel;

class Contents extends Base
{
    public function index($cate=1,$page=1,$limit=10)
    {
        if(is_numeric($cate)&&($cate<=10)&&($cate>=2)){
        }else{
            $cate = 2;
        }
        if(is_numeric($page)&&($page<=0)){
        }else{
            $page = 1;
        }
        $blogList = Blogmodel::getBlogLists($cate,$page,$limit);
        $cateData = Catemodel::queryCate($cate);
        $blogList['count']==0?$pageCount = 1:$pageCount =ceil($blogList['count']/$limit);
        return view("contents/contents",[
            'cate' => $cate,
            'pagenum' => $page,
            'limitnum'=> $limit,
            'catedata' => $cateData,
            'bloglist'=>$blogList['data'],
            'pagecount'=>$pageCount
        ]);
    }
}
