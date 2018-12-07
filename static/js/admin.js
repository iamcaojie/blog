//初始化layui
layui.use(['layer', 'form','element','table'], function(){
var layer = layui.layer
,form = layui.form
,element = layui.element
,tableArticle = layui.table;
    tableArticle.render({
        elem: '#article'
        ,height: 312
        ,url: '/admin/index/queryblog/action/getbloglist' //数据接口
        ,page: true //开启分页
        ,cols: [[ //表头
          {field: 'id', title: '博客ID', width:80, sort: true, fixed: 'left'}
          ,{field: 'blog_title', title: '标题', width:80}
          ,{field: 'blog_text', title: '内容', width:80, sort: true}
          ,{field: 'delete_time', title: '软删除时间', width:80} 
          ,{field: 'update_time', title: '更新时间', width: 177}
          ,{field: 'create_time', title: '创建时间', width: 80, sort: true}
          ,{field: 'blog_category', title: '分类', width: 80, sort: true}
          ,{field: 'read_count', title: '阅读量', width: 80}
          // ,{field: 'read_count', title: '操作', width: 80}
        ]]
    });
    form.on('switch(web-status)', function(data){
        // **全局变量webStatus
        webStatus = data.elem.checked; //开关是否开启，true或者false

    }); 
});

// 初始化wangEditor
var E = window.wangEditor;
var editor = new E('#editor');
editor.create();

// 选项卡切换
$('#createblog').click(function(){
});

// 网站状态切换,后端验证数据合法性
$(function(){ 
    $(".layui-form-item").click(function(){
        if(webStatus){
            data={'switch':'on'};
        }else{
            data={'switch':'off'};
        }
        postdata('/admin/index/webStatus','POST', data);
        // return false;
    });
});
 
// 发布文章
$(function(){ 
    // 捕获编辑器可能修改内容的时间
    var blogText = $("input[name='blog_text']")
    $(".w-e-text").keyup(function(){
        blogText.attr('value',editor.txt.html());
    });
    $(".w-e-text").click(function(){
        blogText.attr('value',editor.txt.html());
    });
    $(".w-e-text").mouseleave(function(){
        blogText.attr('value',editor.txt.html());
    });    
    $(".w-e-text").blur(function(){
        blogText.attr('value',editor.txt.html());
    });
});



document.getElementById('btn1').addEventListener('click', function () {
// 读取 html
alert(editor.txt.html());
}, false)
document.getElementById('btn2').addEventListener('click', function () {
// 读取 text
alert(editor.txt.text());
}, false);


// ajax提交数据函数
function postdata(url,method,data){
    $(function(){ 
        $.ajax({
            type:method,
            url:url,
            data:data,
            success: function(calldata){
                //
            }
        });
    });
}

console.log("欢迎提交bug或建议，联系方式QQ10804842");