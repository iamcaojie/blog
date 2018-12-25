<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:68:"D:\server\nginx\html/phpapp/application/blog\view\detail\detail.html";i:1545750957;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <title>博客详情</title>
        <meta charset="utf-8">
        <meta name="author" content="caojie">
        <meta name="description" content="个人博客" />
        <meta name="keywords" content="个人博客" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="renderer" content="webkit" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <link href="/static/css/Normalize.css" rel="stylesheet"></link>
        <link href="/static/layui/css/layui.css" rel="stylesheet"></link>
        <link href="/static/css/bootstrap.css" rel="stylesheet"></link>
        <link href="/static/css/font-awesome.css" rel="stylesheet"></link>
        <link href="/static/css/detail.css" rel="stylesheet"></link>
        <!--[if lt IE 9]>
            <script src="/static/js/html5shiv.js"></script>
            <script src="/static/js/respond.src.js"></script>
        <![endif]-->
    </head>
    <body>
        <noscript>抱歉，你的浏览器不支持 JavaScript，访问可能出现错误!</noscript>
        <ol class="breadcrumb">
            <li><a href="http://localhost">首页</a></li>
            <li><a href="/blog/python">Python</a></li>
            <li class="active">详情</li>
        </ol>
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="article-detail">
                        <div class="article-title"><h1><?php echo $blogdetail['blog_title']; ?></h1></div>
                        <div class="article-text"><?php echo $blogdetail['blog_html']; ?></div>
                        <div id="comment">
                            <ul id="comment-tab">
                                <li id="comment-list-tab" class="selected"><a>评论列表</a></li>
                                <li id="reply-comment-tab"><a>发布评论</a></li>
                            </ul>
                            <div id="comment-list">
                                <div>评论评论评论评论评论评论评论评论评论评论评论评论评论</div>
                                <div>评论评论评论评论评论评论评论评论评论评论评论评论评论</div>
                            </div>
                            <div id="reply-comment" style="display:none;">
                                <form>
                                    <textarea name="comment_text"></textarea>
                                    <br>
                                    <button id="clear">清空</button>
                                    <button id="submit">提交</button>
                                </form>
                            </div>
                        </div>
                    </div>
        
                </div>
                <div class="col-md-3">
                    <div style="width:100%;height:500px;background:white;">
                        <div>热门推荐</div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/static/js/jquery3.3.1.js"></script>
        <script src="/static/js/bootstrap.js"></script>
        <script src="/static/layui/layui.js"></script>
        <script src="/static/js/toTop.js"></script>
        <script src="/static/js/detail.js"></script>
    </body>
</html>