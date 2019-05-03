<?php
namespace app\web\controller;

class Index
{
    public function index()
    {
        return '网站简介';
    }
    public function timeLine()
    {
        return '时间线。开发中';
    }
    public function api()
    {
        return 'api。开发中';
    }    
    public function article()
    {
        return '文章归档。开发中';
    }
    public function tools()
    {
        return '在线工具。开发中';
    }
    public function doc()
    {
//        return view('doc/doc');
    }
    public function download()
    {
        return '资源下载。开发中';
    }
}
