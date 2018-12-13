//初始化layui
layui.use(['layer', 'form','element','table'], function(){
var layer = layui.layer
,form = layui.form
,element = layui.element
,table = layui.table;
    tableIns = table.render({
        elem: '#article'
        ,height: 400
        ,url: '/admin/blog/queryblog/action/getbloglist' //数据接口
        ,page: true //开启分页
        ,cols: [[ //表头
          {field: 'id', title: '博客ID', width:80, sort: true, fixed: 'left'}
          ,{field: 'blog_title', title: '标题', width:80}
          ,{field: 'cate_id', title: '分类', width: 80, sort: true}
          ,{field: 'blog_text', title: '内容', width:240}
          ,{field: 'delete_time', title: '软删除时间', width:80} 
          ,{field: 'update_time', title: '更新时间', width: 80, sort: true}
          ,{field: 'create_time', title: '创建时间', width: 80, sort: true}
          ,{field: 'read_count', title: '阅读量', width: 80, sort: true}
          ,{field: 'operate', title: '操作', width: 150}
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

var blogId = $('input[name="id"]')
var blogTitle = $('input[name="blog_title"]')


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
    // 捕获编辑器可能修改内容的事件，自动保存文章
    $(".w-e-text").on('keyup click mouseleave',function(){
        autoSave();
    });
    // 手动保存，获取保存状态
    $("#btn3").click(function(){
        // if
        postBlogData('/admin/blog/createblog','POST',getlocalData());
        return false;
    });
    $("#btn4").click(function(){
        postBlogData('/admin/blog/editblog', 'POST', getlocalData());
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


/* 
处理函数




*/ 
// 选项卡切换
function changeTab(tabBox){
    $('#createblog').click(function(){
});
}


// 编辑文章
function editBlog(id){
    // 查询编辑器是否有数据，如有，清空数据或者继续编辑
    if (blogTitle.val() == '' && editor.txt.text()==''){
        getBlogData('/admin/index/queryblog/action/queryblog','GET',{'id':id});
        $("#btn3").hide();
        $("#btn4").show();
    }else{
        layer.confirm('编辑器中还有数据，请选择？', {
            btn: ['清空原数据并继续', '编辑原数据']
            ,anim: 2
            ,btn1: function(index, layero){
                layer.close(index);
                getBlogData('/admin/blog/queryblog/action/queryblog','GET',{'id':id});
                $("#btn3").hide();
                $("#btn4").show();
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
            deleteBlogData('/admin/blog/deleteblog','POST',{'id':id});
        }
        ,btn2: function(index, layero){
            // pass
        }
    });
}

// 清空内容
function emptyBlogData(){
    blogId.val("");
    blogTitle.val("");
    $(".w-e-text").empty();
}

// 编辑时填充数据到编辑页
function fillBlogData(DataBox, data, method){
    if(method='append'){DataBox.append(data);}
    if(method='val'){DataBox.val(data);}
}

// 实时获取编辑数据,键与后台对应
function getlocalData(){
    var data = {};
    data["id"] = blogId.val();
    data["blog_title"] = blogTitle.val();
    // blogCateData =  .val();
    // blogTagData =  .val();
    data["blog_text"] = editor.txt.html();
    return data
}

//自动保存博客数据,id为1
function autoSave(){
    var tempData = getlocalData();
    tempData['id'] = 1;
    postBlogData('/admin/blog/editblog','POST',tempData);
}

// 提交博客数据
function postBlogData(url,method,data){
    $(function(){ 
        $.ajax({
            type:method || 'POST',
            url:url,
            data:data,
            dataType:'json',
            success: function(data){
                if(data.msg == "自动保存完成"){
                    // layer.msg("自动保存");
                }else{
                    layer.msg(data["msg"])
                    emptyBlogData();
                    tableIns.reload();
                }
            },error:function(data){
                layer.msg("保存失败");
            }
        });
    });
}

// 根据id查询博客数据,编辑时调用
function getBlogData(url,method,data){
    $(function(){ 
        $.ajax({
            type:method || 'GET',
            url:url,
            data:data,
            dataType:'json',
            success: function(data){
                // 填充数据到编辑器
                // layer.msg(data.msg);
                emptyBlogData();
                fillBlogData(blogId, data.data["id"], 'val');
                fillBlogData(blogTitle, data.data["blog_title"], 'val');
                fillBlogData($(".w-e-text"), data.data["blog_text"], 'append');
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
            dataType:'json',
            success: function(data){
                layer.msg(data.msg);
                tableIns.reload();
            }
        });
    });
}

console.log("欢迎提交bug或建议，联系方式QQ10804842");