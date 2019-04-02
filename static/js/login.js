//初始化layui
layui.use(['layer','element'], function(){
    var layer = layui.layer,
        element = layui.element;
});
// 登陆
var loginUserName = $("input[name='username']"),
    loginPassWord = $("input[name='password']"),
    loginvCode = $("input[name='vcode']"),
    loginBtn = $("#login-btn");
// 注册
var regUserName = $("input[name='rusername']"),
    regPassWord = $("input[name='rpassword']"),
    regvCode = $("input[name='rvcode']"),
    regMailCode = $("input[name='rmailcode']"),
    regBtn = $("#register-btn");
// 重置
var mUserName = $("input[name='musername']"),
    mPassWord = $("input[name='mpassword']"),
    mvCode = $("input[name='mvcode']"),
    mMailCode = $("input[name='mmailcode']"),
    resetBtn = $("#reset-btn");
    
$(function(){
    // 切换验证码
    $(".captcha").click(function () {
        $(this).attr('src','/captcha.html?r='+Math.random());
    });
    // 发送邮件
    $(".sendMail").click(function(){
        if($(this).attr('data') === 'register'){
            postInfo('POST', '/login/index/sendMail', getRegData());
        }else if($(this).attr('data') === 'reset'){
            postInfo('POST', '/login/index/sendMail', getResetData());
        }
        return false;
    });
    // 登录
    loginBtn.click(function(){
        postInfo('POST', '/login/index/validateLogin', getLoginData());
        return false;
    });
    // 注册
    regBtn.click(function(){
        postInfo('POST', '/login/index/register', getRegData());
        return false;
    });
    // 重置
    resetBtn.click(function () {
        postInfo('POST', '/login/index/resetPassword', getResetData());
        return false;
    });
});

function getLoginData(){
    var loginData = {
        "username":loginUserName.val(),
        "password":hex_md5(loginPassWord.val()),
        "vcode":loginvCode.val()
    };
    return loginData;
}

function getRegData(){
    var regData = {
        "username":regUserName.val(),
        "password":hex_md5(regPassWord.val()),
        "vcode":regvCode.val(),
        "mcode":regMailCode.val()
    };
    return regData;
}
function getResetData(){
    var resetData = {
        "username":mUserName.val(),
        "password":hex_md5(mPassWord.val()),
        "vcode":mvCode.val(),
        "mcode":mMailCode.val()
    };
    return resetData;
}

function postInfo(method, url, data){
      $(function(){ 
        $.ajax({
            type:method || 'POST',
            url:url,
            data:data,
            dataType:'json',
            success: function(data){
                layer.msg(data.msg);
                if(data.msg == '登录成功'){
                    // 刷新父级窗口
                    // location.assign(data.url);
                }
                $(".captcha").attr('src','/captcha.html?r='+Math.random());
            },error:function(data){
                layer.msg("请求失败");
                $(".captcha").attr('src','/captcha.html?r='+Math.random());
            }
        });
    });
}