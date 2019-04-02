<?php
namespace app\blog\controller;
use app\admin\model\Web as Webmodel;
use app\admin\model\Blog as Blogmodel;
use app\admin\model\Cate as Catemodel;

class Contents extends Base
{
    public function index($cate=1,$page=1,$limit=10)
    {
        // 分类下的文章数据
        $data = Blogmodel::getBlogLists($cate,$page,$limit);
        $this->assign('blogData',$data['blogData']);
        // 分类数据
        $cateData = Catemodel::queryCate($cate);
        $data['blogCount']==0?$pageCount = 1:$pageCount =ceil($data['blogCount']/$limit);
        return view("contents/contents",[
            'cate' => $cate,
            'pageNum' => $page,
            'limitNum'=> $limit,
            'cateData' => $cateData,
            'pageCount'=>$pageCount
        ]);
    }
}
