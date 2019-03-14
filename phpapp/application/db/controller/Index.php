<?php
namespace app\db\controller;

use think\Db;

class Index
{
    public function index()
    {
        // 初始化数据库
        print_r(Db::query('show TABLES'));

        echo '初始化数据库...<br>';

        $ddlsql = [
            'DROP TABLE IF EXISTS think_web;',
            'DROP TABLE IF EXISTS think_info;',
            'DROP TABLE IF EXISTS think_image;',
            'DROP TABLE IF EXISTS think_imagecate;',
            'DROP TABLE IF EXISTS think_users;',
            'DROP TABLE IF EXISTS think_auth_group;',
            'DROP TABLE IF EXISTS think_auth_rule;',
            'DROP TABLE IF EXISTS think_auth_group_access;',
            'DROP TABLE IF EXISTS think_blog;',
            'DROP TABLE IF EXISTS think_cate;',
            'DROP TABLE IF EXISTS think_tags;',
            'DROP TABLE IF EXISTS think_blogs_tags;',
            'DROP TABLE IF EXISTS think_links;',
            'DROP TABLE IF EXISTS think_linkcate;',
            'DROP TABLE IF EXISTS think_massage;',
            'DROP TABLE IF EXISTS think_comments;',
            'DROP TABLE IF EXISTS think_download;',
            'DROP TABLE IF EXISTS think_ip;',
            // 网站状态表
            'CREATE TABLE think_web('
                . 'id int UNSIGNED NOT NULL AUTO_INCREMENT, '
                . 'name varchar(10), '// 网站名称
                . 'web_status tinyint(1), '// 网站状态
                . 'domain varchar(50),'// 域名
                . 'ip varchar(50),'// ip
                . 'beian_code varchar(50),'// 备案号
                . 'today_views int,'// 今日访问
                . 'all_views int,' // 总访问
                . 'close_info text,' // 关闭显示页面
                . 'create_time int,'
                . 'update_time int,'
                . 'delete_time int,'
                . 'PRIMARY KEY(id)) '
                . 'DEFAULT CHARSET=utf8;',
            // 网站信息表，备用
            'CREATE TABLE think_info('
                . 'id int UNSIGNED NOT NULL AUTO_INCREMENT, '
                . 'name varchar(10), '
                . 'create_time int, '
                . 'update_time int, '
                . 'delete_time int, '
                . 'PRIMARY KEY(id)) '
                . 'DEFAULT CHARSET=utf8; ',
            // 图片地址表
            'CREATE TABLE think_image('
            . 'id int UNSIGNED NOT NULL AUTO_INCREMENT, '
            . 'name varchar(10), '
            . 'imagecate_id varchar(10), '
            . 'address varchar(100), '
            . 'ext varchar(5), '
            . 'create_time int, '
            . 'update_time int, '
            . 'delete_time int, '
            . 'PRIMARY KEY(id)) '
            . 'DEFAULT CHARSET=utf8; ',
            // 图片分类表（与uploads目录对应）<carousel轮播：1，masterimages主图：2，detailimages详情图：3>
            'CREATE TABLE think_imagecate('
            . 'id int UNSIGNED NOT NULL AUTO_INCREMENT, '
            . 'name varchar(10), '
            . 'dir varchar(20), '
            . 'create_time int, '
            . 'update_time int, '
            . 'delete_time int, '
            . 'PRIMARY KEY(id)) '
            . 'DEFAULT CHARSET=utf8; ',
            // 网站用户表
            'CREATE TABLE think_users('
                . 'id int UNSIGNED NOT NULL AUTO_INCREMENT, '
                .' nickname varchar(20), '
                . 'username varchar(50), '
                . 'password varchar(50), '
                . 'gender tinyint(1), '
                . 'create_time int, '
                . 'update_time int, '
                . 'delete_time int, '
                . 'PRIMARY KEY(id)) '
                . 'ENGINE=MyISAM  DEFAULT CHARSET=utf8;',
            // 用户组表
            'CREATE TABLE think_auth_group('
                . 'id int UNSIGNED  NOT NULL AUTO_INCREMENT,'
                . 'title char(100) NOT NULL DEFAULT "",'
                . 'status tinyint(1) NOT NULL DEFAULT 1,'
                . '`rules` char(80) NOT NULL DEFAULT "",'
                . 'pid mediumint(1) NOT NULL DEFAULT 0, '
                . 'level tinyint(1) NOT NULL DEFAULT 0, '
                . 'sort int(5) NOT NULL DEFAULT 50, '
                . 'PRIMARY KEY(id)) '
                . 'ENGINE=MyISAM  DEFAULT CHARSET=utf8;',
            // think_auth_rule，权限规则表
            'CREATE TABLE think_auth_rule('
                . 'id int UNSIGNED NOT NULL AUTO_INCREMENT, '
                . 'name char(80) NOT NULL DEFAULT "", '
                . 'title varchar(30) NOT NULL DEFAULT "", '
                . 'type tinyint(1) NOT NULL DEFAULT 1, '
                . 'status tinyint(1) NOT NULL DEFAULT 1, '
                . 'conditions char(100) NOT NULL DEFAULT "", '
                . 'pid mediumint(1) NOT NULL DEFAULT 0, '
                . 'level tinyint(1) NOT NULL DEFAULT 0, '
                . 'sort int(5) NOT NULL DEFAULT 50, '
                . 'PRIMARY KEY (id), '
                . 'UNIQUE(name))'
                . 'ENGINE=MyISAM DEFAULT CHARSET=utf8;',
            // 用户组和用户关联表
            'CREATE TABLE think_auth_group_access ('
                . 'id int UNSIGNED NOT NULL AUTO_INCREMENT,'
                . 'uid mediumint(8) UNSIGNED NOT NULL,'
                . 'group_id mediumint(8) UNSIGNED NOT NULL,'
                . 'PRIMARY KEY (id),'
                . 'UNIQUE uid_group_id(uid,group_id),'
                . 'KEY uid(uid),'
                . 'KEY group_id (group_id)) '
                . 'ENGINE=MyISAM DEFAULT CHARSET=utf8;',
            // 博客文章表(n)(cate_id) -- 博客分类表(1)
            'CREATE TABLE think_blog('
                . 'id int UNSIGNED NOT NULL AUTO_INCREMENT, '
                . 'blog_title varchar(30), '
                . 'user_id int,'
                . 'cate_id tinyint(1), '
                . 'unique_tag varchar(50),'
                . 'blog_html text, '
                . 'blog_text text, '
                . 'create_time int, '
                . 'update_time int, '
                . 'delete_time int, '
                . 'read_count int UNSIGNED DEFAULT 0,'
                . 'read_like int UNSIGNED DEFAULT 0,'
                . 'blog_status tinyint(1),'
                . 'PRIMARY KEY(id)) '
                . 'DEFAULT CHARSET=utf8;',
            // 博客分类表(1) -- 博客文章表(n)
            'CREATE TABLE think_cate('
                . 'id int UNSIGNED NOT NULL AUTO_INCREMENT,'
                . 'blog_category varchar(10),'
                . 'cate_detail varchar(100) DEFAULT "",'
                . 'create_time int,'
                . 'update_time int,'
                . 'delete_time int,'
                . 'pid int,'
                . 'sort tinyint(1) NOT NULL DEFAULT 10,'
                . 'PRIMARY KEY(id)) '
                . 'DEFAULT CHARSET=utf8;',
            // 博客标签表(n) -- 博客文章表(n)
            'CREATE TABLE think_tags('
                . 'id int UNSIGNED NOT NULL AUTO_INCREMENT, '
                . 'tag varchar(10), '
                . 'create_time int, '
                . 'update_time int, '
                . 'delete_time int,'
                . 'PRIMARY KEY(id)) '
                . 'DEFAULT CHARSET=utf8;',
            // 中间表  博客标签表(n)(blog_id) -- 博客文章表(n)(tag_id)
            'CREATE TABLE think_blogs_tags('
                . 'id int UNSIGNED NOT NULL AUTO_INCREMENT, '
                . 'tag_id int, '
                . 'blog_id int, '
                . 'create_time int, '
                . 'update_time int, '
                . 'delete_time int, '
                . 'PRIMARY KEY(id)) '
                . 'DEFAULT CHARSET=utf8;',
            // 链接表(n) -- 链接分类表(1)
            'CREATE TABLE think_links('
                . 'id int UNSIGNED NOT NULL AUTO_INCREMENT, '
                . 'link_cate_id int, '
                . 'link_title varchar(10), '
                . 'link varchar(200), '
                . 'create_time int, '
                . 'update_time int,'
                . 'delete_time int,PRIMARY KEY(id)) '
                . 'DEFAULT CHARSET=utf8;', 
            // 链接分类表(1) -- 链接表(n)
            'CREATE TABLE think_linkcate('
                . 'id int UNSIGNED NOT NULL AUTO_INCREMENT, '
                . 'link_cate_title varchar(10), '
                . 'create_time int,'
                . 'update_time int,'
                . 'delete_time int,PRIMARY KEY(id)) '
                . 'DEFAULT CHARSET=utf8;',
            // 留言表
            'CREATE TABLE think_massage('
                . 'id int UNSIGNED NOT NULL AUTO_INCREMENT, '
                . 'massage_title varchar(30), '
                . 'massage_text varchar(200) , '
                . 'contact varchar(50) ,'
                . 'create_time int,'
                . 'update_time int,'
                . 'delete_time int,'
                . 'PRIMARY KEY(id)) '
                . 'DEFAULT CHARSET=utf8;',
            // 评论表(n)(blog_id) -- 博客文章表(1)
            'CREATE TABLE think_comments('
                . 'id int UNSIGNED NOT NULL AUTO_INCREMENT, '
                . 'user_id int, '
                . 'blog_id int, '
                . 'comment_text varchar(200),'
                . 'create_time int,'
                . 'update_time int,'
                . 'delete_time int,'
                . 'PRIMARY KEY(id)) '
                . 'DEFAULT CHARSET=utf8;',
            // ip地址表
            'CREATE TABLE think_ip('
                . 'id int UNSIGNED NOT NULL AUTO_INCREMENT, '
                . 'ip varchar(50),'
                . 'create_time int,'
                . 'update_time int,'
                . 'delete_time int,'
                . 'PRIMARY KEY(id)) '
                . 'DEFAULT CHARSET=utf8;',
        ];

        $dmlsql = [
            'insert into think_web(id, name, web_status, domain, ip, beian_code,today_views,all_views) '
            . 'values (1,"blog", 1,"localhost","00.000.00.000", "鄂ICP备19004169号",0,0);',
            'insert into think_users(id,username,password) '
            . 'values (1,"caojie","d226d500e7899a09458559bf2661a62b")',
            'insert into think_blog(id, blog_title, cate_id, delete_time) '
            . 'values (1, "临时缓存内容", 1, 1);',
            'insert into think_cate(id, blog_category,pid) '
            . 'values (1,"无",0),(2,"Python",0),(3,"PHP",0),(4,"Java",0),(5,"Web前端",0),
                (6,"编程基础",0),(7,"C/C++",0),(8,"服务器",0),(9,"数据库",0),(10,"Linux",0);',
            'insert into think_tags(id, tag) '
            . 'values (1,"原创"),(2,"转载"),(3,"基础"),(4,"技巧"),(5,"重点"),(6,"难点");',
            'insert into think_linkcate(id, link_cate_title) '
            . 'values (1,"主页链接"),(2,"文档链接"),(3,"网站链接"),(4,"友情链接");',
            'insert into think_links(id, link_cate_id, link_title, link) '
            . 'value (1, 1, "我的博客", "http://www.imcaojie.com");',
            'insert into think_imagecate(id, name, dir)'
            .'values (1,"轮播图","carousel"),(2,"主图","masterimage"),(3,"详情图","detailimage")'
        ];
        foreach ($ddlsql as $value)
        {
           Db::execute($value); 
        }
        echo '数据库初始化完成...<br>';
        foreach ($dmlsql as $value)
        {
           Db::execute($value); 
        }
        echo '完成';
    }
}
