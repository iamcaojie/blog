//初始化layui
layui.use(['layer', 'form','element','table','upload'], function(){
    var layer = layui.layer
});

// 初始化wangEditor
var E = window.wangEditor;
var editor = new E('#editor');
editor.create();

var webDomain = $('input[name="domain"]'),
webTheme = $('input[name="theme"]'),
blogId = $('input[name="id"]'),
blogTitle = $('input[name="blog_title"]');


// 所有数据前端不验证，后端验证数据合法性

$(function(){
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
// 获取网站信息数据
function getWebData(){
    webDomain.val();
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
                    articleIns.reload();
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

// 根据id查询博客数据,编辑时填充调用
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
                articleIns.reload();
            }
        });
    });
}

// 获取分类框数据
function getCateData(){
    $.get('/admin/cate/getcatelist',function(data){
        var cateHTML = '';
        for(var i=0;i<data.data.length;i++){
            cateHTML = cateHTML + '<input value="'+data.data[i]['blog_category'] +'"/>';
        }
        cateHTML = cateHTML + '<div><a onlick= "addCate()">新增</a></div>';
        layer.open({
            type: 1,
            skin: 'massageboard-class',
            area: ['500px', '400px'],
            title: '<div><b>分类管理</b></div>',
            content: cateHTML,
            btn: ['提交'],
            yes: function(index, layero){
                // 提交修改
                layer.close(index);
            }
        });
        // $('body').append(cateHTML);
        console.log(cateHTML);
    });
}
// 渲染分类面板

// 添加分类
function addCate(){
    alert('a');
}
// 删除分类
function deleteCate(){
    
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

// 查看评论

// 删除评论

console.log("欢迎提交bug或建议，联系方式QQ10804842");