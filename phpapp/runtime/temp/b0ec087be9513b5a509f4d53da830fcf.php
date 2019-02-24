<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:67:"D:\server\nginx\html/phpapp/application/login\view\login\login.html";i:1550937449;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <title>登录页面</title>
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
        <link href="/static/css/login.css" rel="stylesheet"></link>
        <!--[if lt IE 9]>
            <script src="/static/js/html5shiv.js"></script>
            <script src="/static/js/respond.src.js"></script>
        <![endif]-->
    </head>
    <body>
        <noscript>抱歉，你的浏览器不支持 JavaScript，访问可能出现错误!</noscript>
        <div id="login-box">
            <form id="loginform" action="" method="post">
                <div class="notice">请输入登录信息</div>
                <div id="user">
                    <label><span>账号</span></label> 
                    <input type="text" name="username"/>
                    <div style="height:5px;"></div>
                    <div id="password-box">
                        <label><span>密码</span></label> 
                        <input type="password" name="password"/>
                    </div>
                    <div id="vcode-box" style="display:none;">
                        <label><span>验证码</span></label> 
                        <input type="text" name="vcode"/>
                        <p>
                            <a href="javascript:void(0);" id="sendMail">发送</a>
                        </p>
                    </div>
                </div>
                    <button id="submit-btn" type="submit" class="login" >登录</button>  
            </form>
            <div class="back">
                <a href="http://localhost">返回首页</a>
                <a id="register-btn" href="javascript:void(0)">注册</a>
                <a id="login-btn" href="javascript:void(0)" style="display:none;">登陆</a>
                <a id="forget-btn" href="javascript:void(0)">重置密码</a>
            </div>
        </div>
        </div>
        <script src="/static/js/jquery3.3.1.js"></script>
        <script src="/static/js/bootstrap.js"></script>
        <script src="/static/layui/layui.js"></script>
        <script src="/static/js/canvas-particle.js"></script>
        <script src="/static/js/md5.js"></script>
        <script src="/static/js/toTop.js"></script>
        <script src="/static/js/login.js"></script>
           <script type="text/javascript">
                window.onload = function(){
                        //配置
                        var config = {
                                vx: 4,//点x轴速度,正为右，负为左
                                vy:  4,//点y轴速度
                                height: 2,//点高宽，其实为正方形，所以不宜太大
                                width: 2,
                                count: 120,//点个数
                                color: "176,58,91",//点颜色
                                stroke: "176,58,91",//线条颜色
                                dist: 2000,//点吸附距离
                                e_dist: 10000,//鼠标吸附加速距离
                                max_conn: 10//点到点最大连接数
                        }
                        //调用
                        CanvasParticle(config);
                };
         
</script>
<canvas width="0px" height="0px;" style="top: 0px; left: 0px;"></canvas>
    </body>
</html>