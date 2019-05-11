<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:64:"D:\server\nginx\html/phpapp/application/blog\view\blog\blog.html";i:1557570690;s:66:"D:\server\nginx\html\phpapp\application\blog\view\public\base.html";i:1557574915;}*/ ?>

    
    <!DOCTYPE html>
    <html lang="zh-CN">
        <head>



    <title>我的网站</title>


    
        <meta charset="utf-8">
        <meta name="author" content="caojie">
        <meta name="description" content="个人博客" />
        <meta name="keywords" content="个人博客" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="render" content="webkit" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <link href="/static/css/Normalize.css" rel="stylesheet"/>
        <link href="https://cdn.bootcss.com/twitter-bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
        <link href="https://layui.hcwl520.com.cn/layui-v2.4.5/css/layui.css?v=201811010202" rel="stylesheet" media="all"/>

    <link href="/static/css/common.css" rel="stylesheet"/>
    <link href="/static/css/index.css" rel="stylesheet"/>
    <!--[if lt IE 9]>
        <script src="/static/js/html5shiv.js"></script>
        <script src="/static/js/respond.src.js"></script>
    <![endif]-->
    </head>


    
<body>
<!-- 导航栏 -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <!--左边主题栏-->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="http://<?php echo $webdata['domain']; ?>"><?php echo $webdata['domain']; ?></a>
        </div>
        <!-- 导航条链接 -->
        <span class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php if(is_array($cates) || $cates instanceof \think\Collection || $cates instanceof \think\Paginator): $i = 0;$__LIST__ = is_array($cates) ? array_slice($cates,1,3, true) : $cates->slice(1,3, true); if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate): $mod = ($i % 2 );++$i;if($cate["blog_category"] !== "默认分类"): ?>
                        <li class=""><a href="/blog/contents?cate=<?php echo $cate['id']; ?>&page=1"><?php echo $cate['blog_category']; ?></a></li>
                    <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                <!--下拉栏-->
                <li class="dropdown">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">其他<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php if(is_array($cates) || $cates instanceof \think\Collection || $cates instanceof \think\Paginator): $i = 0;$__LIST__ = is_array($cates) ? array_slice($cates,4,3, true) : $cates->slice(4,3, true); if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate): $mod = ($i % 2 );++$i;?>
                            <li><a href="/blog/contents?cate=<?php echo $cate['id']; ?>&page=1"><?php echo $cate["blog_category"]; ?></a></li>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                            <li role="separator" class="divider"></li>
                        <?php if(is_array($cates) || $cates instanceof \think\Collection || $cates instanceof \think\Paginator): $i = 0;$__LIST__ = is_array($cates) ? array_slice($cates,7,3, true) : $cates->slice(7,3, true); if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate): $mod = ($i % 2 );++$i;?>
                             <li><a href="/blog/contents?cate=<?php echo $cate['id']; ?>&page=1"><?php echo $cate["blog_category"]; ?></a></li>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </li>
            </ul>
            <!--搜索栏-->
            <form class="navbar-form navbar-left" action="/search" method="GET">
                <div class="form-group">
                    <select name="c" class="form-control">
                        <option value="1">文章</option>
                        <option value="2">标签</option>
                        <option value="3">用户</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" name="q" class="form-control" autocomplete="off" placeholder="请输入搜索内容">
                </div>
                <button type="submit" id="search" class="btn btn-default">搜索</button>
            </form>
            <!--登陆注册栏-->
            <ul class="nav navbar-nav navbar-right">
                <?php if($nickname): ?>
                    <li><a class="<?php echo $nickname; ?>" href="/admin" title="后台管理"><?php echo $nickname; ?></a></li>
                    <li><a class="loginoff" href="javascript:void(0);" title="退出登录"><i class="fa fa-sign-out"></i></a></li>
                <?php else: if($username): ?>
                         <li><a class="<?php echo $username; ?>" href="/admin" title="后台管理"><?php echo $username; ?></a></li>
                         <li><a class="loginoff" href="javascript:void(0);" title="退出登录"><i class="fa fa-sign-out"></i></a></li>
                    <?php else: ?>
                        <li>
                             <a class="login" href="javascript:void(0);">注册/登录</a>
                        </li>
                    <?php endif; endif; ?>
            </ul>
        </div>
    </div>
</nav>



    <!--页面内容部分-->
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="channel-box layui-carousel" id="banner">
                    <div carousel-item>
                        <?php if(is_array($bannerImagesData) || $bannerImagesData instanceof \think\Collection || $bannerImagesData instanceof \think\Paginator): $i = 0; $__LIST__ = $bannerImagesData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$bannerImage): $mod = ($i % 2 );++$i;?>
                            <div><img class="carousel-img" src="/uploads/banner/<?php echo $bannerImage['address']; ?>.<?php echo $bannerImage['ext']; ?>">
                            </div>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
                <div class="channel-box" id="notice" style="text-align: center;">
                        <a class="icon" href="/">时间线<br>开发中</a>
                        <a class="icon" href="/">API接口<br>开发中</a>
                        <a class="icon" href="/">文章归档<br>开发中</a>
                        <a class="icon" href="/">在线工具<br>开发中</a>
                        <a class="icon" href="/web/doc.html">在线文档<br>完成</a>
                        <a class="icon" href="/">资源下载<br>开发中</a>
                </div>
                <div id="last-update">
                    <a class="channel">最近更新</a>
                    <?php if(is_array($lastUpdateData) || $lastUpdateData instanceof \think\Collection || $lastUpdateData instanceof \think\Paginator): $i = 0; $__LIST__ = $lastUpdateData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$lastUpdate): $mod = ($i % 2 );++$i;?>
                    <div class="list">
                        <div>
                            <div class="img-box">
                                <a href="/blog/detail?id=<?php echo $lastUpdate['id']; ?>"><img class="article-img" src="<?php echo $lastUpdate['masterimageurl']; ?>"/></a>
                            </div>
                            <div class="article-box">
                                <h1><a href="/blog/detail?id=<?php echo $lastUpdate['id']; ?>"><?php echo $lastUpdate['blog_title']; ?></a></h1>
                                <div class="tags">
                                    <span class="label label-primary"><?php echo $lastUpdate['f_update_time']; ?></span>
                                    <span class="label label-default"><?php echo $lastUpdate['tag'][0]; ?></span>
                                    <span class="label label-success"><?php echo $lastUpdate['tag'][1]; ?></span>
                                    <?php if(is_array($lastUpdate['f_unique_tag']) || $lastUpdate['f_unique_tag'] instanceof \think\Collection || $lastUpdate['f_unique_tag'] instanceof \think\Paginator): $i = 0; $__LIST__ = $lastUpdate['f_unique_tag'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$f_tag): $mod = ($i % 2 );++$i;?>
                                        <span class="label label-info"><?php echo $f_tag; ?></span>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </div>
                                <div class="article-detail"><?php echo $lastUpdate['blog_text_omit']; ?></div>
                            </div>
                        </div>
                        <div class="article-like">
                            <span><?php echo $lastUpdate['read_count']; ?>人阅读</span>
                            <span><?php echo $lastUpdate['read_like']; ?>人点赞</span>
                            <span><?php echo $lastUpdate['commentsCount']; ?>人评论</span>
                            <span style="float:right;">
                                <a href="/blog/detail?id=<?php echo $lastUpdate['id']; ?>">阅读全文>>></a>
                            </span>
                        </div>
                    </div>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
            <div class="col-md-4">
                <div id="about-me" class="channel-box">
                    <a class="channel">关于我</a>
                    <div>
                        <a href="/user?id=1"><img id="avatar" src="<?php echo $userImageUrlData; ?>"/></a>
                    </div>
                    <div id="info" style="text-align: center;">
                        <p style="text-align: center;margin: 5px 0 5px 0">CaoJie</p>
                        <botton data="1" class="btn btn-default follow"><?php echo $btnTextData; ?></botton>
                    </div>
                    <ul id="contact" style="text-align: center;">
                        <li>
                            <a href="https://github.com/iamcaojie" target="_blank" title="Github-iamcaojie">
                                <i class="fa fa-github"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://weibo.com/iamcaojie96" target="_blank" title="微博-入戏太深莫当真">
                                <i class="fa fa-weibo"></i>
                            </a>
                        </li>
                        <li>
                            <a href="http://wpa.qq.com/msgrd?v=3&uin=10804842&site=qq&menu=yes" target="_blank" title="QQ-10804842">
                                <i class="fa fa-qq"></i>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">
                                <i class="fa fa-wechat"></i>
                            </a>
                            <div id="wechat-img"><img src="/static/img/wechat.png"/></div>
                        </li>
                    </ul>
                    <div id="check-in-box" style="text-align: center;margin-top: 20px;">
                        <?php if($checkInData): ?>
                            <div><?php echo $checkInData; ?></div>
                        <?php else: ?>
                            <botton id="check-in" class="btn btn-default btn-lg" style="width: 70%;">每日一签</botton>
                        <?php endif; ?>
                    </div>
                </div>
                <!--<div id="music" class="channel-box" style="display: none;">-->
                    <!--<a class="channel">音乐播放</a>-->
                    <!--<div id="play-box">-->
                        <!--<audio src="">-->
                            <!--<span>浏览器不支持audio标签</span>-->
                        <!--</audio>-->
                        <!--<div style="width:80px;margin: auto;">-->
                            <!--<img src="/static/img/python.jpg" style="width:80px;height:80px;border-radius: 50%;"/>-->
                        <!--</div>-->
                        <!--<div>-->
                            <!--<a id="play-model" href="javascript:void(0);">循环播放</a>-->
                            <!--<a id="prev" href="javascript:void(0);"><i class="fa fa-step-backward" style="font-size: 36px;"></i></a>-->
                            <!--<a id="play" href="javascript:void(0);"><i class="fa fa-play" style="font-size: 36px;"></i></a>-->
                            <!--<a id="next" href="javascript:void(0);"><i class="fa fa-step-forward" style="font-size: 36px;"></i></a>-->
                            <!--<a id="" href="javascript:void(0);">静音</a>-->
                            <!--<span id="voice-bar">-->
                                <!--<span id="voiced-bar" style="background:black;width:67px;height: 2px;"></span>-->
                            <!--</span>-->
                        <!--</div>-->
                    <!--</div>-->
                <!--</div>-->
                <div id="click" class="channel-box">
                    <a class="channel">点击排行</a>
                    <ul id="click-rank">
                        <?php if(is_array($blogRankData) || $blogRankData instanceof \think\Collection || $blogRankData instanceof \think\Paginator): $i = 0; $__LIST__ = $blogRankData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$blogRank): $mod = ($i % 2 );++$i;?>
                            <li>
                                <p>
                                    <span class="number"><?php echo $blogRank['read_count']; ?></span>
                                    <a href="/blog/detail/index/id/<?php echo $blogRank['id']; ?>"><?php echo $blogRank['blog_title']; ?></a>
                                </p>
                            </li>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>
                <div id="tags-list" class="channel-box">
                    <a class="channel">个性标签聚合</a>
                    <div>
                        <ul id="tag">
                            <?php if(is_array($tagData) || $tagData instanceof \think\Collection || $tagData instanceof \think\Paginator): $i = 0; $__LIST__ = $tagData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tag): $mod = ($i % 2 );++$i;?>
                                <li><a href="/search?c=2&q=<?php echo $tag; ?>"><?php echo $tag; ?></a></li>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    </div>
                </div>
                <div id="wechatmp" class="channel-box">
                    <a class="channel">小程序</a>
                    <div>开发中...</div>
                </div>
            </div>
        </div>
    </div>
    <!-- 页面底栏 -->
    <footer>
        <div id="foot">
            <div id="foot-left">
                <!--网站链接-->
                <ul>
                    <?php if(is_array($linkData) || $linkData instanceof \think\Collection || $linkData instanceof \think\Paginator): $i = 0; $__LIST__ = $linkData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$link): $mod = ($i % 2 );++$i;?>
                        <li><a href="<?php echo $link['link']; ?>" target="_blank"><?php echo $link['link_title']; ?></a></li>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
                <!--友情链接-->
            </div>
            <div id="foot-right">
                <!--TODO-->
                <div class="white">占位</div>
                <div class="white">占位</div>
            </div>
        </div>
        <div id="web-info">
            <!--TODO-->
            <span style="display:none;"><a href=""></a></span>
        </div>
        <span id="copyright">COPYRIGHT 2018-2019 CAOJIE. ALL RIGHTS RESERVED.</span><br>
        <span><a href="http://www.miitbeian.gov.cn"><?php echo $webdata['beian_code']; ?></a></span>
        <span>今日pv </span><span>总pv </span>
    </footer>


    
    <div id="sidebar">
        <div id="massage"><i class="fa fa-commenting-o"></i></div>
        <div id="toTop" style="display: none;"><i class="fa fa-chevron-circle-up"></i></div>
    </div>
</body>



    
    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://layui.hcwl520.com.cn/layui-v2.4.5/layui.js?v=201811010202"></script>
    <script src="/static/js/common.js"></script>

    <script src="/static/js/index.js"></script>


    
    </html>


