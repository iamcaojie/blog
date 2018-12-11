<?php
namespace app\db\controller;

use think\View;
use think\Request;
use think\Db;
class Index
{
    public function index()
    {
        // 初始化数据库
        print_r(Db::query('show tables'));

        echo '初始化数据库...';

        $ddlsql = [
            'create table think_web(id int(10), name varchar(10), status varchar(10), domain varchar(50),create_time int(11),update_time int(11),delete_time int(11),primary key(id)) DEFAULT CHARSET=utf8',
            'create table think_info(id int(10), name varchar(10),create_time int(11),update_time int(11),delete_time int(11),primary key(id)) DEFAULT CHARSET=utf8',
            'create table think_users(id int(10), username varchar(10), password varchar(10),permission int(10),create_time int(11),update_time int(11),delete_time int(11),primary key(id)) DEFAULT CHARSET=utf8',
            'create table think_blog(id int(10) AUTO_INCREMENT, blog_title varchar(30), blog_category varchar(10),blog_text char(100),create_time int(11),update_time int(11),delete_time int(11),read_count int(10),primary key(id)) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8',
            'create table think_doclinks(id int(10), name varchar(10), link varchar(100), create_time int(11),update_time int(11),delete_time int(11),primary key(id)) DEFAULT CHARSET=utf8',
            'create table think_weblinks(id int(10), name varchar(10), link varchar(100),create_time int(11),update_time int(11),delete_time int(11),primary key(id)) DEFAULT CHARSET=utf8',
            'create table think_massage(id int(10) AUTO_INCREMENT, massage_title varchar(10), massage_text varchar(100),create_time int(11),update_time int(11),delete_time int(11),primary key(id)) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8',
            'create table think_comments(id int(10), user_id int(10), blog_id int(10), comment_text varchar(100),create_time int(11),update_time int(11),delete_time int(11),primary key(id)) DEFAULT CHARSET=utf8',
            'create table think_downloads(id int(10), name int(10), link varchar(100),primary key(id)) DEFAULT CHARSET=utf8'
        ];
        
        $dmlsql = [
            'insert into think_web(id, name, status, domain) values(1,"blog","on","iamcaojie.com")',
            'insert into think_users(id,username,password,permission) values(1,"caojie","caojie",1)',
            'insert into think_blog(id) values(1)'
        ];
        foreach ($ddlsql as $value)
        {
            // try
            // {
           Db::execute($value); 
            // }
        }
        foreach ($dmlsql as $value)
        {
            // try
            // {
               Db::execute($value); 
            // }

            
        }
        echo '完成';
    }
}
