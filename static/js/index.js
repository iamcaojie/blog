//初始化layui
layui.use(['layer', 'form'], function(){
var layer = layui.layer
,form = layui.form;

});

// jQuery特效
$(document).ready(function(){ 
    // 注册链接拦截
    $("#sign").click(function(){
        layer.msg('还在coding中,暂未开放');
        return false;
    });
    // 检查搜索框
    $("#search").click(function(){
        var search_text = $("#search_text").val()
        if ( search_text == ""){
            layer.msg('请输入搜索内容！！！');
            return false;
        }
    });
});

console.log("hello,小老弟，欢迎提交bug或建议，联系方式QQ10804842")