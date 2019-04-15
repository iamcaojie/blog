layui.use(['layer'], function(){
    var layer = layui.layer
});

var  searchText= $('input[name="q"]');
$(function(){
    // 检查搜索框
    $("#search").click(function(){
        if ( searchText.val() == ""){
            layer.msg('请输入搜索内容！！！');
            return false;
        }
    });
    // 登录注册
    $(".login").click(function () {
        if(!isLogin()){
            getLogin();
        }else{
            window.location.reload();
        }
    });
    $(".loginoff").click(function () {
        $.get('/login/index/loginoff2',function (data) {
            if(data.code == 0){
                window.location.reload();
            }
        });
    });
    // 关注，取消关注，后端渲染必须要有data属性，值为用户id
    $(".follow").click(function () {
        if(isLogin()){
            var userID = $(this).attr('data');
            var info = follow(userID);
            if(info.status === 0){
                $(this).text(info.data);
            }
        }else{
            getLogin();
            layer.msg('请登录后关注');
        }
        return false;
    });
    // 留言
    $('#massage').click(function(){
        layer.open({
            type: 1,
            skin: 'massageboard-class',
            area: ['360px', '400px'],
            title: '<b style="color:#337ab7;">留言板</b>',
            content: '<div id="massage-board"><form >留言主题\n\
            <br><input placeholder="必填，25字以内" name="massage_title"/>\n\
            <br>联系方式<br><input placeholder="选填，最多20字" name="contact"/>\n\
            <br>留言内容<br><textarea id="massage-text" placeholder="选填，最多200字" name="massage_text"></textarea></form>\
            <span id="text-count"></span></div>',
            btn: ['提交'],
            yes: function(index, layero){
                postMassage();
                layer.close(index);
            }
        });
    });
});
jQuery(document).ready(function($) {
    if($(this).scrollTop() <= 600){
        $("#toTop").hide();
    }
    $(window).scroll(function() {
        if($(this).scrollTop() <= 600){
            $("#toTop").hide();
        }
        if($(this).scrollTop() > 600){
            $("#toTop").show();
        }
    });
    $("#toTop").click(function() {
        $("html,body").animate({
            scrollTop:"0px"},500)
        });
});

// 是否登录
function isLogin() {
    var loginStatus = false;
    $.ajax({
        url: '/login/index/isLogin',
        type: 'GET',
        async:false,
        dataType: 'json',
        success: function (data) {
            if(data.code === 0){
                loginStatus = true;
            }else{
                loginStatus = false;
            }
        },
        error: function () {
            layer.msg('服务器错误');
        }
    });
    return loginStatus;
}
// 登录框
function getLogin(){
    layer.open({
        type: 2,
        title: '登录/注册',
        area: ['390px', '550px'],
        content: '/login',
        shadeClose:true,
        btn: ['关闭'],
        yes: function(index, layero){
            layer.close(index);
        }
    });
}

// 关注
function follow(userID) {
    var info = {};
    $.ajax({
        url:'/user/index/follow',
        type:'POST',
        async:false,
        data:{'follow_user_id':userID},
        dataType: 'json',
        success:function(data){
            if(data.code == -1){
                layer.msg(data.msg);
                info.status = -1;
            }else{
                info.status = 0;
                info.data = data.msg;
            }
        },
        error:function(){
            info.status = -1;
        }
    });
    return info;
}

// 提交留言
function postMassage(){
    $(function(){
        var massageTitle = $('input[name="massage_title"]'),
            contact = $('input[name="contact"]'),
            massageText = $('#massage-text');
        var massageData = {"massage_title":massageTitle.val(),
            "contact":contact.val(),
            "massage_text":massageText.val()};
        $.ajax({
            url:'/blog/index/getMassage',
            type:'POST',
            data:massageData,
            dataType: 'json',
            success:function(data){
                layer.msg(data.msg);
            },
            error:function(){
                layer.msg('提交失败');
                return false;
            }
        });
    });
}


// 检测是否为IE
function IEVersion() {
    //取得浏览器的userAgent字符串
    var userAgent = navigator.userAgent;
    //判断是否IE<11浏览器
    var isIE = userAgent.indexOf("compatible") > -1 && userAgent.indexOf("MSIE") > -1;
    //判断是否IE的Edge浏览器
    var isEdge = userAgent.indexOf("Edge") > -1 && !isIE;
    var isIE11 = userAgent.indexOf('Trident') > -1 && userAgent.indexOf("rv:11.0") > -1;
    if(isIE) {
        var reIE = new RegExp("MSIE (\\d+\\.\\d+);");
        reIE.test(userAgent);
        var fIEVersion = parseFloat(RegExp["$1"]);
        if(fIEVersion == 7) {
            return 7;
        } else if(fIEVersion == 8) {
            return 8;
        } else if(fIEVersion == 9) {
            return 9;
        } else if(fIEVersion == 10) {
            return 10;
        } else {
            return 6;//IE版本<=7
        }
    } else if(isEdge) {
        return 'edge';//edge
    } else if(isIE11) {
        return 11; //IE11
    }else{
        return -1;//不是ie浏览器
    }
}
