//初始化layui
layui.use(['layer', 'form','element','table'], function(){
var layer = layui.layer
,form = layui.form
,element = layui.element
,table = layui.table;
    tableIns = table.render({
        elem: '#article'
        ,height: 400
        ,url: '/admin/index/queryblog/action/getbloglist' //数据接口
        ,page: true //开启分页
        ,cols: [[ //表头
          {field: 'id', title: '博客ID', width:80, sort: true, fixed: 'left'}
          ,{field: 'blog_title', title: '标题', width:80}
          ,{field: 'blog_category', title: '分类', width: 80, sort: true}
          ,{field: 'blog_text', title: '内容', width:80}
          ,{field: 'delete_time', title: '软删除时间', width:80} 
          ,{field: 'update_time', title: '更新时间', width: 177, sort: true}
          ,{field: 'create_time', title: '创建时间', width: 80, sort: true}
          ,{field: 'read_count', title: '阅读量', width: 80, sort: true}
          ,{field: 'operate', title: '操作', width: 160}
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

// var 

// 选项卡切换
$('#createblog').click(function(){
});

// 所有数据前端不验证，后端验证数据合法性


$(function(){ 
    // 网站状态切换
    $(".layui-form-item").click(function(){
        if(webStatus){
            var webData={'switch':'on'};
        }else{
            var webData={'switch':'off'};
        }
        postdata('/admin/index/webStatus','POST', webData);
        return false;
    });
    
    // 发布文章
    // 捕获编辑器可能修改内容的事件，自动保存文章，不改id
    $(".w-e-text").on('keyup click mouseleave blur',function(){
        var data = {'id':0,'blog_title':$('input[name="blog_title"]').val(),'blog_text':editor.txt.html()};
        autoSave(data);
    });
    // 手动保存，获取保存状态，重置内容，删除临时保存数据
    $("#btn3").click(function(){
        var blogData = {'blog_title':$('input[name="blog_title"]').val(),'blog_text':editor.txt.html()};
        postBlogData('/admin/index/createblog','POST',blogData);
        return false;
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

// 编辑文章
function editBlog(id){
    // 查询编辑器是否有数据，如有，清空数据或者继续编辑
    if ($('input[name="blog_title"]').val() == '' && editor.txt.text()==''){
        getBlogData('/admin/index/queryblog/action/queryblog','GET',{'id':id});
        
    }else{
        layer.confirm('编辑器中还有数据，请选择？', {
            btn: ['清空原数据并继续', '编辑原数据']
            ,anim: 2
            ,btn1: function(index, layero){
                layer.close(index);
                getBlogData('/admin/index/queryblog/action/queryblog','GET',{'id':id});
                // 
            }
            ,btn2: function(index, layero){
                // 编辑原数据
                
            }
        });
    }
}
// 删除文章
function deleteBlog(id){
    layer.confirm('确定删除文章？', {
        btn: ['删除', '返回']
        ,anim: 2
        ,btn1: function(index, layero){
            layer.close(index);
            deleteBlogData('/admin/index/deleteblog','POST',{'id':id});
        }
        ,btn2: function(index, layero){
            // pass
        }
    });
}

// 函数
//自动保存博客数据
function autoSave(data){
    postBlogData('/admin/index/editblog','POST',data);
}
// 提交博客数据
function postBlogData(url,method,data){
    $(function(){ 
        $.ajax({
            type:method || 'POST',
            url:url,
            data:data,
            success: function(data){
                layer.msg("ajax上载完成");
                tableIns.reload();
            }
        });
    });
}
// 根据id查询博客数据
function getBlogData(url,method,data){
    $(function(){ 
        $.ajax({
            type:method || 'GET',
            url:url,
            data:data,
            success: function(data){
                layer.msg("ajax查询完成");
               // 填充数据到编辑器
               // 
            }
        });
    });
}
// 根据id删除博客
function deleteBlogData(url,method,data){
    $(function(){ 
        $.ajax({
            type:method || 'POST',
            url:url,
            data:data,
            success: function(data){
                layer.msg('删除完成');
                tableIns.reload();
            }
        });
    });
}
// 编辑时填充数据到编辑器
function fillBlogdata(data){
    
}
 
console.log("欢迎提交bug或建议，联系方式QQ10804842");