//初始化layui
layui.use(['layer', 'form','carousel'], function(){
var layer = layui.layer
,form = layui.form
,carousel = layui.carousel;
    //轮播
    carousel.render({
        elem: '#carousel'
        ,width: '100%' 
        ,arrow: 'always' 
        ,height: carouselAutoHeight()
    });
    
});



$(function(){ 
    // 注册链接拦截
    $("#sign").click(function(){
        layer.msg('coding中,暂未开放');
        return false;
    });
    // 检查搜索框
    $("#search").click(function(){
        var search_text = $("#search_text").val();
        if ( search_text == ""){
            layer.msg('请输入搜索内容！！！');
            return false;
        }
    });
    //响应轮播容器高度
    $(window).resize(function(){
        $('#carousel').css("height",carouselAutoHeight());
    });
    // 联系方式
    $('#wechat').hover(function(){
        $('#wechat-box').toggle();
    });
    // 留言
    $('#massage').click(function(){
        layer.open({
            type: 1, 
            skin: 'massageboard-class',
            area: ['500px', '400px'],
            title: '<div style="color: rgb(176,58,91);"><b>有什么想说的，在这里畅所欲言^_^</b></div>',
            content: '<div id="massage-board"><form >留言主题\n\
            <br><input placeholder="必填，25字以内" name="massage_title"/>\n\
            <br>联系方式<br><input placeholder="选填，最多20字" name="contact"/>\n\
            <br>留言内容<br><textarea id="massage-text" placeholder="选填，最多200字" name="massage_text"></textarea></form></div>' 
            ,btn: ['提交']
            ,yes: function(index, layero){
                postMassage();
                layer.close(index);
            }
        });
    });
});

// 函数
//根据窗口获取轮播图高度
function carouselAutoHeight(){
    var windowWidth = $(window).width();
    var imgWidth = $('.col-sm-8').css('width').replace('px','');
    if ( windowWidth > 1200) {return '456.34px'};
    if ( windowWidth >=992 && windowWidth <= 1200) {return '375.2px'};
    if ( windowWidth >=765 && windowWidth <= 992) {return '285.97px'};
    if ( windowWidth < 765) {return ((imgWidth*9/16)-2)+'px'};
}

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
// 检测留言内容，提交时后台也需检测
function checkMassage(){
    //
}
// 检测评论时间间隔

// 提交留言
function postMassage(){
    $(function(){
        var massageData = {"massage_title":$('input[name="massage_title"]').val(),"massage_text":$('input[name="massage_text"]').val()};
        $.ajax({
            url:'/blog/index/getmassage',
            type:'post',
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
console.log("欢迎提交bug或建议，联系方式QQ10804842")
