//初始化layui
layui.use(['layer', 'form','element','table'], function(){
var layer = layui.layer
,form = layui.form
,element = layui.element
,table = layui.table;
    // 文章列表
    tableIns = table.render({
        elem: '#article'
        ,height: 400
        ,url: '/admin/blog/queryblog/action/getbloglist' //数据接口
        ,page: true //开启分页
        ,cols: [[ //表头
          {field: 'id', title: '博客ID', width:80, sort: true, fixed: 'left'}
          ,{field: 'blog_title', title: '标题', width:80}
          ,{field: 'cate', title: '分类', width: 80}
          ,{field: 'tag', title: '标签', width: 80}
          ,{field: 'blog_text', title: '内容', width:240}
          ,{field: 'delete_time', title: '软删除时间', width:80} 
          ,{field: 'update_time', title: '更新时间', width: 80, sort: true}
          ,{field: 'create_time', title: '创建时间', width: 80, sort: true}
          ,{field: 'read_count', title: '阅读量', width: 80, sort: true}
          ,{field: 'operate', title: '操作', width: 150}
        ]]
    });
    // 消息列表
    massageTableIns = table.render({
        elem: '#massage-list'
        ,height: 400
        ,url: '/admin/massage/getmassagelist' //数据接口
        ,page: true //开启分页
        ,cols: [[ //表头
          {field: 'id', title: 'ID', width:80, sort: true, fixed: 'left'}
          ,{field: 'massage_title', title: '主题', width:160}
          ,{field: 'massage_text', title: '内容', width: 400}
          // ,{field: 'delete_time', title: '软删除时间', width:80} 
          ,{field: 'update_time', title: '更新时间', width: 80, sort: true}
          ,{field: 'create_time', title: '创建时间', width: 80, sort: true}
          // ,{field: 'operate', title: '操作', width: 150}
        ]]
        });
        // 评论列表
    commentTableIns = table.render({
        elem: '#comment-list'
        ,height: 400
        ,url: '/admin/comments/getcommentslist' //数据接口
        ,page: true //开启分页
        ,cols: [[ //表头
          {field: 'id', title: 'ID', width:80, sort: true, fixed: 'left'}
          ,{field: 'use_id', title: '用户id', width:80}
          ,{field: 'blog_id', title: '博客id', width: 80}
          ,{field: 'tag', title: '标签', width: 80}
          ,{field: 'comment_text', title: '内容', width:240}
          ,{field: 'delete_time', title: '软删除时间', width:80} 
          ,{field: 'update_time', title: '更新时间', width: 80, sort: true}
          ,{field: 'create_time', title: '创建时间', width: 80, sort: true}
          // ,{field: 'operate', title: '操作', width: 150}
        ]]
    });
    // 获取开关值
    form.on('switch(web-status)', function(data){
        // **全局变量webStatus
        webStatus = data.elem.checked; //开关是否开启，true或者false
    }); 
    
    // jQuery可以代替的功能
    // 获取分类值
//    form.on('radio(blog-category)', function(data){
//        blogCate = data.value; 
//    });  
    // 获区来源分类值
//    form.on('radio(tag-origin)', function(data){
//        blogOrigin = data.value; 
//        console.log(blogOrigin);
//    }); 
    // 获取分级分类值
//    form.on('radio(tag-level)', function(data){
//        blogLevel = data.value; 
//    }); 
});

// 初始化wangEditor
var E = window.wangEditor;
var editor = new E('#editor');
editor.create();

var blogId = $('input[name="id"]');
var blogTitle = $('input[name="blog_title"]');


// 所有数据前端不验证，后端验证数据合法性

$(function(){ 
    // 网站状态切换
    $("#web-switch").click(function(){
        if(webStatus){
            var webData={'switch':'on'};
        }else{
            var webData={'switch':'off'};
        }
        postData('/admin/index/webStatus','POST', webData);
        return false;
    }); 
    $('#manage-classification').click(function(){
        getClassData();
    });
    // 发布文章
    // 捕获编辑器可能修改内容的事件，自动保存文章
    $(".w-e-text").on('keyup click mouseleave',function(){
        autoSave();
    });
    $("#btn1").click(function(){
        alert(editor.txt.html());
    });
    $("#btn2").click(function(){
        alert(editor.txt.text());
    });
    // 手动保存，获取保存状态
    $("#btn3").click(function(){
        if(check()){
        postData('/admin/blog/createblog','POST',getlocalData());
        } 
        return false;
    });
    // 保存编辑博客
    $("#btn4").click(function(){
        postData('/admin/blog/editblog', 'POST', getlocalData());
        $("#btn4").hide();
        $("#btn3").show();
        return false;
    });
});


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
        getBlogData('/admin/blog/queryblog/action/queryblog','GET',{'id':id});
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
                // pass
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
function fillBlogData(data){
    blogId.val(data["data"]["id"]);
    blogTitle.val(data["data"]["blog_title"]);
    $(".w-e-text").append(data["data"]["blog_html"]);
}
// 检查数据合法性
function check(){
    if(blogTitle.val() == ""){
    layer.msg("请输入标题");
    return false;
    }
    if(editor.txt.text() == ""){
    layer.msg("请输入内容");
    return false;
    }
    return true;
}
// 实时获取编辑数据,键与后台对应
function getlocalData(){
    var data = {};
    var tagData = new Array($('input[name="tag-origin"]:checked').val(),$('input[name="tag-level"]:checked').val());
    data["id"] = blogId.val();
    data["blog_title"] = blogTitle.val();
    data["cate_id"] =  $('input[name="blog-category"]:checked').val();
    data["blog_html"] = editor.txt.html();
    data["blog_text"] = editor.txt.text();
    var blogData = {"blogdata":data, "tagdata":tagData};
    console.log(blogData);
    return blogData;
}

//自动保存博客数据,id为1
function autoSave(){
    var tempData = getlocalData();
    tempData["blogdata"]["id"] = 1;
    postData('/admin/blog/editblog','POST',tempData);
}

// 提交数据(保存博客、编辑博客)
function postData(url,method,data){
    $(function(){ 
        $.ajax({
            type:method || 'POST',
            url:url,
            data:data,
            dataType:'json',
            success: function(data){
                // 所有后台回调操作
                if(data.msg == "自动保存完成"){
                    // layer.msg("自动保存");
                }else if(data.msg == "保存成功" || data.msg == "修改成功" ){
                    layer.msg(data["msg"]);
                    emptyBlogData();
                    tableIns.reload();
                }else if(data.msg == ""){
                    //
                }else{
                    //
                }
            },error:function(data){
                layer.msg("操作失败");
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
                emptyBlogData();
                fillBlogData(data);
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

// 获取分类框数据
function getClassData(){
    $.get('/admin/cate/getcatelist',function(data){
        var classData = data.data;
        var classDataStr = '';
        for(var i = 1; i<=data.length; i++){
            for(var j = 1; i<=data[i].length; j++){
                classData = classData + data[i][j];
            }
        }
        console.log(classData);
        layer.open({
            type: 1, 
            area: ['500px', '300px'],
            title: '分类管理',
            content: classData
            ,btn: ['提交']
            ,yes: function(index, layero){
                layer.close(index);
            }
        });
    });
}
// 添加分类
function addClass(){
    
}
// 删除分类
function deleteClass(){
    
}
// 编辑分类
function editClass(){
    
}
// 查看留言和评论
function viewitem(url){
    $.ajax({
        url:url,
        type:method || 'GET',
        data:data,
        dataType:'json',
        success: function(data){
            layer.open({
                type: 1, 
                area: ['500px', '300px'],
                title: '分类管理',
                content: classData
                ,btn: ['提交']
                ,yes: function(index, layero){
                    layer.close(index);
                }
            });
        }
    });
}
// 提交分类

// 查看留言

// 删除留言

// 查看评论

// 删除评论


console.log("欢迎提交bug或建议，联系方式QQ10804842");