<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:64:"D:\server\nginx\html/phpapp/application/blog\view\blog\blog.html";i:1545489927;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <title>我的博客</title>
        <meta charset="utf-8">
        <meta name="author" content="caojie">
        <meta name="description" content="个人博客" />
        <meta name="keywords" content="个人博客" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="renderer" content="webkit" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <link href="/static/css/Normalize.css" rel="stylesheet"></link>
        <link href="/static/layui/css/layui.css"  media="all" rel="stylesheet"></link>
        <link href="/static/css/bootstrap.css" rel="stylesheet"></link>
        <link href="/static/css/font-awesome.css" rel="stylesheet"></link>
        <link href="/static/css/index.css" rel="stylesheet"></link>
        <!--[if lt IE 9]>
            <script src="/static/js/html5shiv.js"></script>
            <script src="/static/js/respond.src.js"></script>
        <![endif]-->
    </head>
    <body>
        <noscript>抱歉，你的浏览器不支持 JavaScript，访问可能出现错误!</noscript>
        <!-- 导航栏 -->
        <nav class="navbar navbar-default navbar-fixed-top">
          <div class="container-fluid">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="http://localhost">iamcaojie.com</a>
            </div>
            <!-- 导航条链接 -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                <li class=""><a href="/blog/python">Python</a></li>
                <li><a href="/blog/php">PHP</a></li>
                <li><a href="/blog/java">Java</a></li>
                <li class="dropdown">
                  <a href="" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">其他<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="/blog/javascript">JavaScript</a></li>
                    <li><a href="/blog/cplusplus">C++</a></li>
                    <li><a href="/blog/computer">计算机体系</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="/blog/linux">Linux</a></li>
                    <li><a href="/blog/db">数据库</a></li>
                    <li><a href="/blog/server">服务器</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="/blog/other">杂谈</a></li>
                  </ul>
                </li>
              </ul>
              <form class="navbar-form navbar-left" action="search" method="get">
                <div class="form-group">
                  <input type="text" id="search_text" name="q" class="search-form" placeholder="搜索博客内容">
                </div>
                <button type="submit" id="search" class="btn search-btn">搜索</button>
              </form>
              <ul class="nav navbar-nav navbar-right">
                <li><a id="sign" href="/admin">注册</a></li>
                <li><a id="login" href="/login">登录</a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">相关链接<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="https://github.com/iamcaojie" target="_blank">Git</a></li>
                    <li><a href="https://leetcode-cn.com/" target="_blank">Leetcode</a></li>
                        <li><a href="/api">Api</a></li>
                    <li><a href="/api">Timeline</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="/books">读书笔记</a></li>
                    <li><a href="/tools/online">在线工具</a></li>
                    <li><a href="/tools/download">下载</a></li>
                    <li><a href="/tools/doclinks">文档链接</a></li>
                    <li><a href="/tools/weblinks">实用网站</a></li>
                  </ul>
                </li>
              </ul>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>
        <!--页面内容部分-->
        <div class="container">
            <!-- 轮播 -->
            <div class="row" >
                <div class="col-sm-8 col-md-8">
                <!-- <img src="/static/img/contents.png" ></img> -->
                    <div class="layui-carousel" id="carousel">
                          <div carousel-item>
                            <div><img class="carousel-img" src="/static/img/contents.png" ></img></div>
                            <div><img class="carousel-img" src="/static/img/contents.png" ></img></div>
                            <div><img class="carousel-img" src="/static/img/contents.png" ></img></div>
                          </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 intro">
                    <div id="introduction">
                        <div id="avatar">
                            <div>
                                <a href="/temp/index/resume"><img src="/static/img/avatar.jpg"></img></a>
                            </div>
                        </div>
                        <div id="introduction-box">
                            <dl>
                                <div>
                                <dt>标题标题</dt>
                                <dd>内容内容</dd>
                                </div>
                                <div>
                                <dt>标题标题</dt>
                                <dd>内容内容</dd>
                                </div>
                                <div>
                                <dt>标题标题</dt>
                                <dd>内容内容</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 展示栏 -->
            <div class="row" >
                    <h1><i class="fa fa-rotate-left"></i><a href="http://www.baidu.com"> 最近更新</a></h1>
                <div class="col-sm-6 col-md-4 col-lg-3 ">
                    <div class="thumbnail">
                        <div class="img-Placeholder">
                            <a href="http://www.baidu.com">
                                <img src="/static/img/img.jpg" style="width:300px; height:150px;"/>
                            </a>
                        </div>
                        <div class="topic-contents">
                            <a href="https://www.baidu.com">
                               <span class="title">主题</span>
                               <br/>
                               <span class="content">文本内容</span> 
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 下一栏 -->
            <div class="row" style="height:300px;">
                <h1><i class="fa fa-star"></i> 热门点击</h1>
            </div>
            <!-- 下一栏 -->
            <div class="row" style=>
                <h1><i class="fa fa-sort"> 分类浏览</i></h1>
                <div class="col-sm-8 col-md-4 col-lg-4">
                    <div class="contents">
                        <div class="contents-title">
                            <h2>Python</h2>
                            <div class="more">
                                <div>
                                    <a href="/blog/python"><span class="glyphicon glyphicon-plus-sign"></span>更多</a>
                                </div>
                            </div>
                        </div>
                        <div class="contents-text">
                            <ul>
                                <li>
                                    <span class="article-title">使用 Python 解释器</span>
                                    <span class="article-date">2018-10-20</span>
                                </li>
                                <li>
                                    <span class="article-title">使用 Python 解释器</span>
                                    <span class="article-date">2018-10-20</span>
                                </li>                                <li>
                                    <span class="article-title">使用 Python 解释器</span>
                                    <span class="article-date">2018-10-20</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>                
                <div class="col-sm-8 col-md-4 col-lg-4">
                    <div class="contents">
                        <div class="contents-title">
                            <h2>Python</h2>
                            <div class="more">
                                <div>
                                    <a href="/blog/python"><span class="glyphicon glyphicon-plus-sign"></span>更多</a>
                                </div>
                            </div>
                        </div>
                        <div class="contents-text">
                            <ul>
                                <li>
                                    <span class="article-title">使用 Python 解释器</span>
                                    <span class="article-date">2018-10-20</span>
                                </li>
                                <li>
                                    <span class="article-title">使用 Python 解释器</span>
                                    <span class="article-date">2018-10-20</span>
                                </li>                                <li>
                                    <span class="article-title">使用 Python 解释器</span>
                                    <span class="article-date">2018-10-20</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>                
                <div class="col-sm-8 col-md-4 col-lg-4">
                    <div class="contents">
                        <div class="contents-title">
                            <h2>Python</h2>
                            <div class="more">
                                <div>
                                    <a href="/blog/python"><span class="glyphicon glyphicon-plus-sign"></span>更多</a>
                                </div>
                            </div>
                        </div>
                        <div class="contents-text">
                            <ul>
                                <li>
                                    <span class="article-title">使用 Python 解释器</span>
                                    <span class="article-date">2018-10-20</span>
                                </li>
                                <li>
                                    <span class="article-title">使用 Python 解释器</span>
                                    <span class="article-date">2018-10-20</span>
                                </li>                                <li>
                                    <span class="article-title">使用 Python 解释器</span>
                                    <span class="article-date">2018-10-20</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
            <!-- 其他 -->
            <div class="row">
               
            </div>
            <!-- 侧边悬浮栏 -->
            <div id="Sidebar">
                <div id="Sidebar-box">
                    <div id="massage-box"></div>
                    <div id="wechat-box" style='display:none'>
                        <img src="/static/img/wechat.png"/>
                    </div>
                </div>
                <div id="Sidebar-display">
                <div id="massage"></div>
                <div id="wechat"></div>
                <div id="toTop"></div>
               </div>
            </div>

        </div>
        
        <!-- 页面底栏 -->
        <!-- <div class="container-fluid"> -->
            <footer>
                <div id="foot"></div>
                <span id="copyright">版权所有 © iamcaojie.com</span>
            </footer>
        <!-- </div> -->
        <script src="/static/js/jquery3.3.1.js"></script>
        <script src="/static/js/bootstrap.js"></script>
        <script src="/static/layui/layui.js"></script>
        <script src="/static/js/index.js"></script>
    </body>
</html>