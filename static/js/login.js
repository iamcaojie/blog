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
var nickName = $("input[name='nickname']"),
    regUserName = $("input[name='rusername']"),
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
var hero = ["盘古","猪八戒","嫦娥","上官婉儿","李信","沈梦溪","伽罗","盾山","司马懿","孙策","元歌","米莱狄","狂铁","弈星","裴擒虎","杨玉环","公孙离","明世隐","女娲","梦奇","苏烈","百里玄策","百里守约","铠","鬼谷子","干将莫邪","东皇太一","大乔","黄忠","诸葛亮","哪吒","太乙真人","蔡文姬","雅典娜","杨戬","成吉思汗","钟馗","虞姬","李元芳","张飞","刘备","后羿","牛魔","孙悟空","亚瑟","橘右京","娜可露露","不知火舞","张良","花木兰","兰陵王","王昭君","韩信","刘邦","姜子牙","露娜","程咬金","安琪拉","貂蝉","关羽","老夫子","武则天","项羽","达摩","狄仁杰","马可波罗","李白","宫本武藏","典韦","曹操","甄姬","夏侯惇","周瑜","吕布","芈月","扁鹊","孙膑","钟无艳","阿轲","高渐离","刘禅","庄周","鲁班七号","孙尚香","嬴政","妲己","赵云","廉颇"];
$(function(){
    $("#set-nickname").click(function () {
        nickName.val(hero[Math.round(Math.random()*hero.length)]);
    });
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
    // 点击复制
    $('.copy').click(function () {
        var copyText = $(this).siblings("span").text();
        // IE实现
        // window.clipboardData.setData("text/plain",copyText);
        // Chrome实现
        // event.clipboardData.setData("text/plain",'1');
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
        "nickname":nickName.val(),
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
                    // 刷新父窗口
                    parent.window.location.reload();
                }
                $(".captcha").attr('src','/captcha.html?r='+Math.random());
            },error:function(data){
                layer.msg("请求失败");
                $(".captcha").attr('src','/captcha.html?r='+Math.random());
            }
        });
    });
}