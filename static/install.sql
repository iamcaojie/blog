SET FOREIGN_KEY_CHECKS=0;
set character_set_server=utf8;
set character_set_database=utf8;
set character_set_client=utf8;
set character_set_connection=utf8;
set character_set_database=utf8;
set character_set_results=utf8;
set character_set_server=utf8;

DROP TABLE IF EXISTS [prefix_]web;
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
    web_status tinyint(1) NOT NULL DEFAULT 1 COMMENT '网站状态',
    domain varchar(50) NOT NULL DEFAULT '' COMMENT '网站域名',
    ip varchar(50) NOT NULL DEFAULT '127.0.0.1' COMMENT '网站ip地址', 
    beian_code varchar(50) NOT NULL DEFAULT '' COMMENT '备案号', 
    today_views int NOT NULL DEFAULT 0 COMMENT '今日访问', 
    all_views int NOT NULL DEFAULT 0 COMMENT '总访问',  
    close_info text NOT NULL COMMENT '关闭时显示的页面',
    create_time int NOT NULL DEFAULT 0,
    update_time int NOT NULL DEFAULT 0,
    delete_time int NOT NULL DEFAULT 0,
    PRIMARY KEY(id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT '网站状态表';

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
    rules char(200) NOT NULL DEFAULT '',
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
    blog_html text,
    blog_text text,
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
    blog_category varchar(40) NOT NULL DEFAULT '',
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
    tag varchar(20) NOT NULL DEFAULT '未设置分类',
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
    link_cate_title varchar(50) NOT NULL DEFAULT '',
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

insert into [prefix_]web(id, name, web_status, domain, ip, beian_code,today_views,all_views,close_info)
    values (1,'blog', 1,'imcaojie.com','127.0.0.1', '鄂ICP备19004169号-1',0,0,'<div style="text-align:center"><h1>网站维护中</h1><div><a href="https://github.com/iamcaojie">Github</a></div></div>');

insert into [prefix_]users(id,nickname,username,password) 
    values (1,'入戏太深','imcaojie@qq.com','d226d500e7899a09458559bf2661a62b'),
    (2,'后台测试账号','demo1@qq.com','43da34d87d7c36746917008be5a891e8'),
    (3,'用户测试账号1','demo2@qq.com','43da34d87d7c36746917008be5a891e8'),
    (4,'用户测试账号2','demo3@qq.com','43da34d87d7c36746917008be5a891e8'),
    (5,'用户测试账号3','demo4@qq.com','43da34d87d7c36746917008be5a891e8');

insert into [prefix_]blog(id, blog_title, cate_id, delete_time) 
    values (1, '临时缓存内容', 1, 1);

insert into [prefix_]cate(id, blog_category,pid) 
    values (1,'默认分类',0),(2,'Python',0),(3,'PHP',0),(4,'Java',0),(5,'Web前端',0),
    (6,'编程基础',0),(7,'C/C++',0),(8,'服务器',0),(9,'数据库',0),(10,'Linux',0);

insert into [prefix_]tags(id, tag) 
    values (1,'原创'),(2,'转载'),(3,'基础'),(4,'技巧'),(5,'重点'),(6,'难点');

insert into [prefix_]linkcate(id, link_cate_title) 
    values (1,'主页链接'),(2,'文档链接'),(3,'网站链接'),(4,'友情链接');

insert into [prefix_]imagecate(id, name, dir)
    values (1,'轮播图','banner'),(2,'主图','master'),(3,'详情图','detail'),(4,'头像','avatar');

insert into [prefix_]image(id, imagecate_id,address,ext)
    values (1,4,'avatar','jpg'),
      (2,1,'banner1','jpg'),
      (3,1,'banner2','jpg'),
      (4,1,'banner3','jpg');

insert into [prefix_]links(id,link_cate_id,link_title,link)
  values(1,3,'Git','https://github.com/'),
  (2,3,'Stack Overflow','https://stackoverflow.com/'),
  (3,3,'SegmentFault','https://segmentfault.com/'),
  (4,3,'V2EX','https://www.v2ex.com/'),
  (5,3,'CSDN','https://www.csdn.net/'),
  (6,3,'infoQ','https://www.infoq.cn/'),
  (7,3,'Awesomes','https://www.awesomes.cn/'),
  (8,3,'Google','https://www.google.com.hk/'),
  (9,3,'LeetCode','https://leetcode-cn.com/'),
  (10,3,'牛客网','https://www.nowcoder.com/'),
  (11,3,'码云','https://gitee.com/'),
  (12,3,'Linux公社','https://www.linuxidc.com/'),
  (13,3,'掘金','https://juejin.im/'),
  (14,3,'博客园','https://www.cnblogs.com/'),
  (15,3,'开源中国','https://www.oschina.net/'),
  (16,3,'LearnKu','https://learnku.com/'),
  (17,3,'并发编程网','http://ifeve.com/'),
  (18,3,'Python中文开发者社区','https://www.pythontab.com/'),
  (19,3,'知乎','https://www.zhihu.com/'),
  (20,3,'慕课网','https://www.imooc.com/'),
  (21,3,'网易云课堂','https://study.163.com/'),
  (22,3,'网易公开课','https://open.163.com/'),
  (23,3,'中国大学MOOC','https://www.icourse163.org/'),
  (24,3,'Coursera','https://www.coursera.org/'),
  (25,3,'TED','https://www.ted.com/'),
  (26,3,'阿里云','https://www.aliyun.com/'),
  (27,3,'Dribbble','https://dribbble.com/'),
  (28,3,'Pinterest','https://www.pinterest.com/'),
  (29,3,'花瓣网','https://huaban.com/'),
  (30,3,'LOFTER','http://www.lofter.com/');

insert into [prefix_]auth_rule(id,name,title,type,status,conditions,pid,level,sort)
  values(1,'index/index','后台界面',1,1,'',0,0,50),

  (2,'web/index','显示系统设置',1,1,'',0,0,50),
  (3,'web/getWebList','获取系统设置',1,1,'',2,1,50),
  (4,'web/webStatus','修改网站状态',1,1,'',2,1,50),
  (5,'web/editWeb','编辑网站信息',1,1,'',2,1,50),

  (6,'blog/index','文章列表',1,1,'',0,0,50),
  (7,'blog/queryBlog','查询文章',1,1,'',6,1,50),
  (8,'blog/createBlog','创建文章',1,1,'',6,1,50),
  (9,'blog/editBlog','编辑文章',1,1,'',6,1,50),
  (10,'blog/deleteBlog','删除文章',1,1,'',6,1,50),

  (11,'cate/index','显示分类列表',1,1,'',0,0,50),
  (12,'cate/getCateTreeList','获取所有分类',1,1,'',11,1,50),
  (13,'cate/createcate','创建分类',1,1,'',11,1,50),
  (14,'cate/editcate','编辑分类',1,1,'',11,1,50),
  (15,'cate/signdeletecate','隐藏分类',1,1,'',11,1,50),
  (16,'cate/deletecate','删除分类',1,1,'',11,1,50),
  (17,'cate/recover','恢复隐藏分类',1,1,'',11,1,50),

  (18,'links/getLinksList','获取链接列表',1,1,'',0,0,50),
  (19,'links/createLinks','创建链接',1,1,'',18,1,50),
  (20,'links/queryLink','查询链接',1,1,'',18,1,50),
  (21,'links/deleteLink','删除链接',1,1,'',18,1,50),

  (22,'massage/getMassageList','留言列表',1,1,'',0,0,50),
  (23,'massage/createMassage','创建留言',1,1,'',22,1,50),
  (24,'massage/editMassage','编辑留言',1,1,'',22,1,50),
  (25,'massage/queryMassage','查询留言',1,1,'',22,1,50),
  (26,'massage/deleteMassage','删除留言',1,1,'',22,1,50),

  (27,'comments/getCommentsList','评论列表',1,1,'',0,0,50),
  (28,'comments/editComments','编辑评论',1,1,'',27,1,50),
  (29,'comments/queryComments','查询评论',1,1,'',27,1,50),
  (30,'comments/deleteComments','删除评论',1,1,'',27,1,50),

  (31,'tags/getTagsList','标签列表',1,1,'',0,0,50),
  (32,'tags/createTag','创建标签',1,1,'',31,1,50),
  (33,'tags/editTags','编辑标签',1,1,'',31,1,50),
  (34,'tags/queryTags','查询标签',1,1,'',31,1,50),
  (35,'tags/deleteTags','删除标签',1,1,'',31,1,50),

  (36,'image/index','获取图片列表',1,1,'',0,0,50),
  (37,'image/deleteImage','删除图片',1,1,'',36,1,50),

  (38,'upload/banner','轮播图上传',1,1,'',0,0,50),
  (39,'upload/master','主图上传',1,1,'',0,0,50),
  (40,'upload/detail','详情图上传',1,1,'',0,0,50),

  (41,'auth/index','显示权限',1,1,'',0,0,50),
  (42,'auth/queryAuthRule','查询权限',1,1,'',41,1,50),
  (43,'auth/editAuthRule','修改权限',1,1,'',41,1,50),
  (44,'auth/deleteAuthRule','删除权限',1,1,'',41,1,50),
  (45,'auth/queryAuthGroup','查询用户组',1,1,'',41,1,50),
  (46,'auth/addAuthGroup','增加用户组',1,1,'',41,1,50),
  (47,'auth/editAuthGroup','编辑用户组',1,1,'',41,1,50),
  (48,'auth/deleteAuthGroup','删除用户组',1,1,'',41,1,50),
  (49,'auth/queryUser','查询用户',1,1,'',41,1,50),
  (50,'auth/addUser','增加用户',1,1,'',41,1,50),
  (51,'auth/editUser','编辑用户',1,1,'',41,1,50),
  (52,'auth/deleteUser','删除用户',1,1,'',41,1,50),

  (53,'downloads/getDownloadsList','显示下载列表',1,1,'',0,0,50),
  (54,'downloads/createDownloads','创建下载',1,1,'',53,1,50),
  (55,'downloads/editDownloads','编辑下载',1,1,'',53,1,50),
  (56,'downloads/deleteDownloads','删除下载',1,1,'',53,1,50);

insert into [prefix_]auth_group(id,title,status,rules,pid,level,sort)
  values(1,'管理员组',1,'',0,0,50),
    (2,'超级管理员',1,'1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,53,55,56',1,1,50),
    (3,'测试管理员',1,'1,2,3,6,7,11,12,18,25,27,29,31,34,36,38,39,40,41,42,45,49,53',1,1,50),
    (4,'用户组',1,'',0,0,50),
    (5,'普通用户',1,'38,39,40',4,1,50);

insert into [prefix_]auth_group_access(id,uid,group_id)
  values(1,1,2),(2,2,3),(3,3,5),(4,4,5),(5,5,5);






