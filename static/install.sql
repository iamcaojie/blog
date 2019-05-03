DROP TABLE IF EXISTS [prefix_]web;
DROP TABLE IF EXISTS [prefix_]info;
DROP TABLE IF EXISTS [prefix_]image;
DROP TABLE IF EXISTS [prefix_]imagecate;
DROP TABLE IF EXISTS [prefix_]users;
DROP TABLE IF EXISTS [prefix_]auth_group;
DROP TABLE IF EXISTS [prefix_]auth_rule;
DROP TABLE IF EXISTS [prefix_]auth_group_access;
DROP TABLE IF EXISTS [prefix_]blog;
DROP TABLE IF EXISTS [prefix_]cate;
DROP TABLE IF EXISTS [prefix_]tags;
DROP TABLE IF EXISTS [prefix_]blogs_tags;
DROP TABLE IF EXISTS [prefix_]links;
DROP TABLE IF EXISTS [prefix_]linkcate;
DROP TABLE IF EXISTS [prefix_]massage;
DROP TABLE IF EXISTS [prefix_]comments;
DROP TABLE IF EXISTS [prefix_]reply_comment;
DROP TABLE IF EXISTS [prefix_]download;
DROP TABLE IF EXISTS [prefix_]ip;
DROP TABLE IF EXISTS [prefix_]follow;
DROP TABLE IF EXISTS [prefix_]account;
DROP TABLE IF EXISTS [prefix_]reply;
DROP TABLE IF EXISTS [prefix_]favorite;

CREATE TABLE [prefix_]web(
    id int UNSIGNED NOT NULL AUTO_INCREMENT,
    name varchar(10) NOT NULL DEFAULT '' COMMENT '网站名称',
    web_status tinyint(1) NOT NULL DEFAULT 0 COMMENT '网站状态',
    domain varchar(50) NOT NULL DEFAULT '' COMMENT '网站域名',
    ip varchar(50) NOT NULL DEFAULT '127.0.0.1' COMMENT '网站ip地址', 
    beian_code varchar(50) NOT NULL DEFAULT '' COMMENT '备案号', 
    today_views int NOT NULL DEFAULT 0 COMMENT '今日访问', 
    all_views int NOT NULL DEFAULT 0 COMMENT '总访问',  
    close_info text NOT NULL DEFAULT '' COMMENT '关闭时显示的页面',
    create_time int NOT NULL DEFAULT 0,
    update_time int NOT NULL DEFAULT 0,
    delete_time int NOT NULL DEFAULT 0,
    PRIMARY KEY(id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT '网站状态表';

CREATE TABLE [prefix_]info(
    id int UNSIGNED NOT NULL AUTO_INCREMENT,
    name varchar(10) NOT NULL DEFAULT '',
    create_time int, 
    update_time int, 
    delete_time int, 
    PRIMARY KEY(id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT '网站信息表'; 

CREATE TABLE [prefix_]account(
    id int UNSIGNED NOT NULL AUTO_INCREMENT,
    title varchar(50),
    username varchar(50),
    password varchar(50),
    create_time int,
    update_time int,
    delete_time int,
    PRIMARY KEY(id)
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT '账号表'; 

CREATE TABLE [prefix_]image(
    id int UNSIGNED NOT NULL AUTO_INCREMENT, 
    name varchar(10), 
    imagecate_id varchar(10), 
    address varchar(100), 
    ext varchar(5), 
    create_time int, 
    update_time int, 
    delete_time int, 
    PRIMARY KEY(id)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COMMENT '图片地址表(管理全部图片)'; 

CREATE TABLE [prefix_]imagecate(
    id int UNSIGNED NOT NULL AUTO_INCREMENT, 
    name varchar(10), 
    dir varchar(20), 
    create_time int, 
    update_time int, 
    delete_time int, 
    PRIMARY KEY(id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT '图片分类表（与uploads目录对应）1:banner轮播,2:master主图,3:detail详情图,4:用户头像'; 

CREATE TABLE [prefix_]users(
    id int UNSIGNED NOT NULL AUTO_INCREMENT, 
    nickname varchar(20) NOT NULL DEFAULT '', 
    username varchar(50) NOT NULL, 
    password varchar(50) NOT NULL, 
    gender tinyint(1) NOT NULL DEFAULT 3,
    avatar_image_id int DEFAULT 1, 
    create_time int, 
    update_time int, 
    delete_time int, 
    UNIQUE(username),
    PRIMARY KEY(id)
)ENGINE=INNODB  DEFAULT CHARSET=utf8 COMMENT '网站用户表';

CREATE TABLE [prefix_]auth_group(
    id int UNSIGNED  NOT NULL AUTO_INCREMENT,
    title char(100) NOT NULL DEFAULT '',
    status tinyint(1) NOT NULL DEFAULT 1,
    rules char(80) NOT NULL DEFAULT '',
    pid mediumint(1) NOT NULL DEFAULT 0, 
    level tinyint(1) NOT NULL DEFAULT 0, 
    sort int(5) NOT NULL DEFAULT 50, 
    create_time int, 
    update_time int, 
    delete_time int, 
    PRIMARY KEY(id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT '用户组表';

CREATE TABLE [prefix_]auth_rule(
    id int UNSIGNED NOT NULL AUTO_INCREMENT, 
    name char(80) NOT NULL DEFAULT '' COMMENT '控制器方法',  
    title varchar(30) NOT NULL DEFAULT '' COMMENT '权限名称',  
    type tinyint(1) NOT NULL DEFAULT 1 COMMENT '认证方式',  
    status tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否开启认证',  
    conditions char(100) NOT NULL DEFAULT '' COMMENT '规则表达式',  
    pid mediumint(1) NOT NULL DEFAULT 0, 
    level tinyint(1) NOT NULL DEFAULT 0, 
    sort int(5) NOT NULL DEFAULT 50, 
    create_time int, 
    update_time int, 
    delete_time int, 
    PRIMARY KEY (id), 
    UNIQUE KEY name(name)
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT '权限规则表';

CREATE TABLE [prefix_]auth_group_access (
    id int UNSIGNED NOT NULL AUTO_INCREMENT,
    uid mediumint(8) UNSIGNED NOT NULL,
    group_id mediumint(8) UNSIGNED NOT NULL,
    create_time int, 
    update_time int, 
    delete_time int, 
    PRIMARY KEY (id),
    UNIQUE KEY uid_group_id(uid,group_id),
    KEY uid(uid),
    KEY group_id(group_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT '用户组和用户关联表';

CREATE TABLE [prefix_]blog(
    id int UNSIGNED NOT NULL AUTO_INCREMENT, 
    blog_title varchar(30) NOT NULL DEFAULT '', 
    user_id int NOT NULL DEFAULT 1,
    cate_id tinyint(1) NOT NULL DEFAULT 1, 
    image_id varchar(50) NOT NULL DEFAULT 1 COMMENT '多个主图', 
    unique_tag varchar(50) DEFAULT '',
    blog_html text DEFAULT '', 
    blog_text text DEFAULT '', 
    create_time int, 
    update_time int, 
    delete_time int, 
    read_count int UNSIGNED DEFAULT 0,
    read_like int UNSIGNED DEFAULT 0,
    blog_status tinyint(1) NOT NULL DEFAULT 0 COMMENT '默认不显示',  
    PRIMARY KEY(id)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COMMENT '博客文章表(n)(cate_id) 博客分类表(1)';

CREATE TABLE [prefix_]cate(
    id int UNSIGNED NOT NULL AUTO_INCREMENT,
    blog_category varchar(10) NOT NULL DEFAULT '',
    cate_detail varchar(100) DEFAULT '',
    create_time int,
    update_time int,
    delete_time int,
    pid int,
    sort tinyint(1) NOT NULL DEFAULT 10,
    PRIMARY KEY(id)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COMMENT '博客分类表(1) 博客文章表(n)';

CREATE TABLE [prefix_]tags(
    id int UNSIGNED NOT NULL AUTO_INCREMENT, 
    tag varchar(10) NOT NULL DEFAULT '未设置分类', 
    create_time int, 
    update_time int, 
    delete_time int,
    PRIMARY KEY(id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT '博客标签表(n) 博客文章表(n)';

CREATE TABLE [prefix_]blogs_tags(
    id int UNSIGNED NOT NULL AUTO_INCREMENT, 
    tag_id int NOT NULL, 
    blog_id int NOT NULL, 
    create_time int, 
    update_time int, 
    delete_time int, 
    PRIMARY KEY(id)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COMMENT '中间表 博客标签表(n)(blog_id) 博客文章表(n)(tag_id)';

CREATE TABLE [prefix_]links(
    id int UNSIGNED NOT NULL AUTO_INCREMENT, 
    link_cate_id int NOT NULL DEFAULT 1, 
    link_title varchar(50) NOT NULL DEFAULT '', 
    link varchar(200) NOT NULL DEFAULT '', 
    create_time int, 
    update_time int,
    delete_time int,
    PRIMARY KEY(id)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COMMENT '链接表(n) -- 链接分类表(1)'; 

CREATE TABLE [prefix_]linkcate(
    id int UNSIGNED NOT NULL AUTO_INCREMENT, 
    link_cate_title varchar(10) NOT NULL DEFAULT '', 
    create_time int,
    update_time int,
    delete_time int,
    PRIMARY KEY(id)
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT '链接分类表(1)链接表(n)';

CREATE TABLE [prefix_]massage(
    id int UNSIGNED NOT NULL AUTO_INCREMENT, 
    massage_title varchar(30) NOT NULL DEFAULT '', 
    massage_text varchar(200) NOT NULL DEFAULT '', 
    contact varchar(50) NOT NULL DEFAULT '',
    create_time int,
    update_time int,
    delete_time int,
    PRIMARY KEY(id)
)ENGINE=INNODB  DEFAULT CHARSET=utf8 COMMENT '留言表';

CREATE TABLE [prefix_]comments(
    id int UNSIGNED NOT NULL AUTO_INCREMENT, 
    user_id int UNSIGNED NOT NULL DEFAULT 1, 
    blog_id int UNSIGNED NOT NULL DEFAULT 1, 
    comment_text varchar(200) NOT NULL DEFAULT '',
    create_time int,
    update_time int,
    delete_time int,
    PRIMARY KEY(id)
) ENGINE=INNODB  DEFAULT CHARSET=utf8 COMMENT '评论表(n)(blog_id) 博客文章表(1)';

CREATE TABLE [prefix_]reply(
    id int UNSIGNED NOT NULL AUTO_INCREMENT, 
    user_id int UNSIGNED NOT NULL DEFAULT 1, 
    comment_id int UNSIGNED NOT NULL DEFAULT 1 COMMENT '对应的评论',
    reply_text varchar(200) NOT NULL DEFAULT '',
    create_time int,
    update_time int,
    delete_time int,
    PRIMARY KEY(id)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COMMENT '评论回复表(n)(blog_id) 评论表(1)'; 

CREATE TABLE [prefix_]ip(
    id int UNSIGNED NOT NULL AUTO_INCREMENT, 
    ip varchar(50) NOT NULL DEFAULT '',
    create_time int,
    update_time int,
    delete_time int,
    PRIMARY KEY(id)
)ENGINE=INNODB DEFAULT CHARSET=utf8 COMMENT 'ip地址表';

CREATE TABLE [prefix_]follow(
    id int UNSIGNED NOT NULL AUTO_INCREMENT, 
    user_id int UNSIGNED NOT NULL DEFAULT 1 COMMENT '用户',
    followed_user int UNSIGNED NOT NULL DEFAULT 1 COMMENT '关注用户id',
    status smallint NOT NULL DEFAULT 1 COMMENT '状态(1,已关注 0,互相关注)',
    create_time int, 
    update_time int, 
    delete_time int, 
    PRIMARY KEY(id)
) ENGINE=INNODB  DEFAULT CHARSET=utf8 COMMENT '用户关注表';

CREATE TABLE [prefix_]favorite(
    id int UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id int UNSIGNED NOT NULL DEFAULT 1,
    blog_id int UNSIGNED NOT NULL DEFAULT 1,
    create_time int,
    update_time int,
    delete_time int,
    PRIMARY KEY(id)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COMMENT '用户收藏表';

insert into [prefix_]web(id, name, web_status, domain, ip, beian_code,today_views,all_views) 
    values (1,'blog', 1,'localhost','127.0.0.1', '鄂ICP备19004169号',0,0);

insert into [prefix_]users(id,nickname,username,password) 
    values (1,'入戏太深','caojie','d226d500e7899a09458559bf2661a62b');

insert into [prefix_]blog(id, blog_title, cate_id, delete_time) 
    values (1, '临时缓存内容', 1, 1);

insert into [prefix_]cate(id, blog_category,pid) 
    values (1,'默认分类',0),(2,'Python',0),(3,'PHP',0),(4,'Java',0),(5,'Web前端',0),
    (6,'编程基础',0),(7,'C/C++',0),(8,'服务器',0),(9,'数据库',0),(10,'Linux',0);

insert into [prefix_]tags(id, tag) 
    values (1,'原创'),(2,'转载'),(3,'基础'),(4,'技巧'),(5,'重点'),(6,'难点');

insert into [prefix_]linkcate(id, link_cate_title) 
    values (1,'主页链接'),(2,'文档链接'),(3,'网站链接'),(4,'友情链接');

insert into [prefix_]links(id, link_cate_id, link_title, link) 
    values (1, 1, '我的博客', 'http://www.imcaojie.com');

insert into [prefix_]imagecate(id, name, dir)
    values (1,'轮播图','banner'),(2,'主图','master'),(3,'详情图','detail'),(4,'头像','avatar');

insert into [prefix_]image(id, imagecate_id,address,ext)
    values (1,4,'avatar','jpg');
