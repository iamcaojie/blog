<?php
namespace app\Search\controller;

use think\Controller;

class Index extends Controller
{
    public function index($category = 'blog' , $q = '请输入搜索关键词')
    {
        switch ($category)
        {
            // 博客搜索
            case 'blog':
                echo 'blog'.$q;
                break;
            // 标签搜索
            case 'tag':
                echo 'tag'.$q;
                break;
            // 用户搜索
            case 'user':
                echo 'user'.$q;
                break;
            default:
                $this ->redirect('/');
        }
    }
}
