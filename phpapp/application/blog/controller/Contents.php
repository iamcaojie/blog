<?php
namespace app\blog\controller;

use app\admin\model\Blog as Blogmodel;
use app\admin\model\Cate as Catemodel;

class Contents
{
    public function index($cate=1,$page=1,$limit=10)
    {
        if(is_numeric($cate)&&($cate<=10)&&($cate>=2)){
        }else{
            $cate = 2;
        }
        $blogList = Blogmodel::getBlogLists($cate,$page,$limit);
        $cateData = Catemodel::queryCate($cate);
        return view("contents/contents",[
            'catedata' => $cateData,
            'bloglist'=>$blogList['data'],
            'pagecount'=>$blogList['count']
        ]);
    }
}
