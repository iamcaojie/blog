//初始化layui
layui.use(['layer', 'form', 'colorpicker'], function(){
var layer = layui.layer
,form = layui.form
,colorpicker = layui.colorpicker;
colorpicker.render({
    elem: '#test1'  //绑定元素
  });
});

// jQuery特效
$(function(){ 
    //手机
    // 编辑背景特效
    $("#edit-canvas").click(function(){
        alert("值为: " + $("input[name='password']").val());
    });
    // MD5加密
   
});

console.log("欢迎提交bug或建议，联系方式QQ10804842")