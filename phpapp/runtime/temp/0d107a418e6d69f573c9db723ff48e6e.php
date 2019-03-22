<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:65:"D:\server\nginx\html/phpapp/application/admin\view\cate\cate.html";i:1552573594;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <title>管理后台</title>
        <meta charset="utf-8">
        <meta name="author" content="caojie">
        <meta name="description" content="个人博客" />
        <meta name="keywords" content="个人博客" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="renderer" content="webkit" />
        <!-- <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"> -->
        <link href="/static/css/Normalize.css" rel="stylesheet"></link>
        <link href="/static/layui/css/layui.css" rel="stylesheet"></link>
         <!--<link href="/static/css/bootstrap.css" rel="stylesheet"></link>-->
        <!--<link href="/static/css/font-awesome.css" rel="stylesheet"></link>-->
        <link href="/static/css/cate.css" rel="stylesheet"></link>
    </head>
    <body>
        <div class="layui-tab layui-tab-brief" lay-filter="cate-manage">
            <ul class="layui-tab-title">
                <li class="layui-this">添加分类</li>
                <li>分类预览</li>
            </ul>
            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">
                    <div id="add-cate">
                        <form class="layui-form" action="/admin/cate/createcate" method="post">
                            <div class="layui-input-block">
                                <label class="layui-form-label">上级分类</label>
                                <div class="layui-inline">
                                    <select name="pid">
                                        <option value="0">顶级分类</option>
                                        <?php if(is_array($cates) || $cates instanceof \think\Collection || $cates instanceof \think\Paginator): $i = 0; $__LIST__ = $cates;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate): $mod = ($i % 2 );++$i;?>
                                            <option value="<?php echo $cate['id']; ?>"><?php echo $cate['blog_category']; ?></option>
                                        <?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="layui-input-block">
                                <label class="layui-form-label">分类名称</label>
                                <div class="layui-inline">
                                    <input name="blog_category" class="layui-input" autocomplete="off" placeholder="必填"/>
                                </div>
                            </div>
                            <div class="layui-input-block">
                                <label class="layui-form-label">分类详情</label>
                                <div class="layui-inline">
                                    <input name="cate_detail" class="layui-input" autocomplete="off" placeholder="选填"/>
                                </div>
                            </div>
                            <button id="add-cate-btn" class="layui-btn layui-btn-sm">添加分类</button>
                        </form>
                    </div>
                </div>
                <div class="layui-tab-item">
                    <button id="recover-btn" class="layui-btn layui-btn-sm">显示已隐藏的分类</button>
                    <button id="refresh-btn" class="layui-btn layui-btn-normal layui-btn-sm">刷新页面</button>
                    <table id="catebox" class="layui-table" lay-filter="catebox"></table>
                </div>
            </div>
        </div>
    </body>
    <script type="text/html" id="bar">
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="sdel">隐藏分类</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="adel">删除分类</a>
    </script>
    <script src="/static/js/jquery3.3.1.js"></script>
    <!-- <script src="/static/js/bootstrap.js"></script> -->
    <script src="/static/layui/layui.js"></script>
    <script src="/static/js/cate.js"></script>
    </body>
</html>