<?php
namespace app\tools\controller;

class Index
{
    public function index()
    {
        return '工具';
    }
    public function online()
    {
        return '在线工具';
    }
    public function download()
    {
        return '下载';
    }    
    public function doc()
    {
        return '文档';
    }
}
