//初始化layui
layui.use(['layer'], function(){
    var layer = layui.layer;
});

var userName = $("input[name='username']"),
    passWord = $("input[name='password']"),
    vCode = $("input[name='vcode']"),
    loginBtn = $("#login-btn"),
    registerBtn = $("#register-btn"),
    passwordBox = $("#password-box"),
    vcodeBox = $("#vcode-box"),
    sendMailBtn = $("#sendmail-btn"),
    submitBtn = $("#submit-btn");
    
$(function(){ 
    // 注册/登录/重置密码切换
    registerBtn.click(function(){
        submitBtn.text("注册");
        passwordBox.show();
        vcodeBox.show();
        loginBtn.show();
        registerBtn.hide();
    });
    loginBtn.click(function(){
        submitBtn.text("登录");
        passwordBox.show();
        vcodeBox.hide();
        loginBtn.hide();
        vcodeBox.hide();
        registerBtn.show();
    });
    $("#forget-btn").click(function(){
        submitBtn.text("重置密码");
        passwordBox.show();
        vcodeBox.show();
        loginBtn.show();
        registerBtn.show();
    });
    // 发送邮件
    $("#sendMail").click(function(){
        if(check()){
            sendMail('POST', '/login/index/sendMail', getData()); 
        }
        return false;
    });
    // 注册，登录，重置密码
    submitBtn.click(function(){
        if(check()){
            if(submitBtn.text() == "登录"){
                valiDate('POST', '/login/index/validatelogin', getData());
            }else if(submitBtn.text() === "注册"){
                register('POST', '/login/index/register', getData());
            }else if(submitBtn.text() === "重置密码"){
                resetPassword('POST', '/login/index/resetpassword', getData());
            }else{
                layer.msg("参数错误");
            }
            return false;
        }
    });
});

function getData(){
    var data = {
        "username":userName.val(),
        "password":hex_md5(passWord.val())
    };
    if(submitBtn.text() === "注册"){
        data["action"] = "注册账号";
        data["vcode"] = vCode.val();
    }else if(submitBtn.text() === "重置密码"){
        data["action"] = "重置密码";
        data["vcode"] = vCode.val();
    }
    return data;
}
function check(){
    if(userName.val() == "") {
        layer.msg("用户名不能为空");
        return false;
    }else if(passWord.val() == ""){
        layer.msg("密码不能为空");
        return false;
    }
    return true;
};

function valiDate(method, url, data){
      $(function(){ 
        $.ajax({
            type:method || 'POST',
            url:url,
            data:data,
            dataType:'json',
            success: function(data){
                layer.msg(data.msg);
                if(data.code == 0){
                    location.assign(data.url);
                }
            },error:function(data){
                layer.msg("请求失败");
            }
        });
    });
}

function register(method, url, data){
      $(function(){ 
        $.ajax({
            type:method || 'POST',
            url:url,
            data:data,
            dataType:'json',
            success: function(data){
                layer.msg(data.msg);
            },error:function(data){
                layer.msg("请求失败");
            }
        });
    });
}
function resetPassword(method, url, data){
      $(function(){ 
        $.ajax({
            type:method || 'POST',
            url:url,
            data:data,
            dataType:'json',
            success: function(data){
                layer.msg(data.msg);
            },error:function(data){
                layer.msg("请求失败");
            }
        });
    });
}
function sendMail(method, url, data){
      $(function(){ 
        $.ajax({
            type:method || 'POST',
            url:url,
            data:data,
            dataType:'json',
            success: function(data){
                layer.msg(data.msg);
            },error:function(data){
                layer.msg("请求失败");
            }
        });
    });
}

console.log("欢迎提交bug,建议或漏洞,联系方式QQ：10804842")