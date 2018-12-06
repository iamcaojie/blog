//初始化layui
function initLayui(){
layui.use(['layer', 'form'], function(){
var layer = layui.layer
,form = layui.form;
});
}
// 初始化wangEditor
function initwangEditor(){
var E = window.wangEditor;
var editor = new E('#editor');
editor.create();
document.getElementById('btn1').addEventListener('click', function () {
// 读取 html
alert(editor.txt.html())
}, false)
document.getElementById('btn2').addEventListener('click', function () {
// 读取 text
alert(editor.txt.text());
}, false);
}
$('#createblog').click(function(){
    getView('/admin/index/getcreateblogview','get');
    initLayui();
    initwangEditor();
});

// ajax获取页面函数
function getView(url,method){
    $(function(){ 
        $.ajax({
            type:method,
            url:url,
            success: function(data){
                var html = '';
                $('#container').append(data);
            }
        });
    });
}

console.log("欢迎提交bug或建议，联系方式QQ10804842")