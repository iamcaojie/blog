//初始化layui
layui.use(['layer', 'form'], function(){
var layer = layui.layer
,form = layui.form;

});

    var E = window.wangEditor;
    var editor = new E('#editor');
    // 或者 var editor = new E( document.getElementById('editor') )
    editor.create();
document.getElementById('btn1').addEventListener('click', function () {
    // 读取 html
    alert(editor.txt.html())
}, false)
document.getElementById('btn2').addEventListener('click', function () {
    // 读取 text
    alert(editor.txt.text())
}, false)


// jQuery特效
$(function(){ 
    // 注册链接拦截

});

console.log("欢迎提交bug或建议，联系方式QQ10804842")