//初始化layui
layui.use(['layer', 'form','carousel'], function(){
var layer = layui.layer
,form = layui.form
,carousel = layui.carousel;
  //轮播实例
  carousel.render({
    elem: '#carousel'
    ,width: '100%' 
    ,arrow: 'always' 
    ,height: '456.34px'
  });
});
//根据窗口获取轮播图高度
// function carouselheight(){
    // if ($(window).width() > ) {return '456.34px'};
// }

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

// jQuery特效
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
    
    // $(window).resize(function(){
        // if $(window).width()
        // var box = $('#introduction').css('height');
        // $('#carousel').css("height",);
        // alert($('#introduction').css('height'));
    // });
});

console.log("欢迎提交bug或建议，联系方式QQ10804842")
// alert(IEVersion());