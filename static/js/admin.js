//初始化layui
layui.use(['layer', 'form','element','table','upload'], function(){
var layer = layui.layer,
    form = layui.form,
    element = layui.element,
    table = layui.table,
    upload = layui.upload;

    var uploadInst = upload.render({
        elem: '#imguploadbtn', //绑定元素
        bindAction: '#uploadaction', //指向一个按钮触发上传
        url: '/admin/upload/carousel', //上传接口
        auto: false,
        accept: 'images',
        multiple: true,
        number: 3,
        choose: function(obj){
            //将每次选择的文件追加到文件队列
            var files = obj.pushFile();
            //预读本地文件，如果是多文件，则会遍历。(不支持ie8/9)
            obj.preview(function(index, file, result){
                $('#img-list').append('<img src="'+ result +'" alt="'+ file.name +'" class="layui-upload-img">');
                //obj.resetFile(index, file, '123.jpg'); //重命名文件名，layui 2.3.0 开始新增
                //这里还可以做一些 append 文件列表 DOM 的操作
                //obj.upload(index, file); //对上传失败的单个文件重新上传，一般在某个事件中使用
                //delete files[index]; //删除列表中对应的文件，一般在某个事件中使用
            });
        },
        done: function(res){
            layer.msg(res.msg);
        },
        error: function(){
            layer.msg('上传失败');
        }
    });

    // 文章列表
    articleIns = table.render({
        elem: '#article',
        height: 400,
        url: '/admin/blog/queryblog/action/getbloglist', //数据接口
        page: true, //开启分页
        toolbar: 'default', //开启工具栏
        cols: [[ //表头
            {type: 'checkbox', fixed: 'left'},
            {field: 'id', title: '博客ID', width:80, sort: true, fixed: 'left'},
            {field: 'user_id', title: '用户ID', width:80, sort: true},
            {field: 'blog_title', title: '标题', width:80},
            {field: 'f_cate', title: '分类', width: 80},
            {field: 'tag', title: '标签', width: 80},
            {field: 'blog_text', title: '内容', width:240},
            // {field: 'delete_time', title: '删除时间', width:80},
            {field: 'update_time', title: '更新时间', width: 80, sort: true},
            {field: 'create_time', title: '创建时间', width: 80, sort: true},
            {field: 'read_count', title: '阅读量', width: 80, sort: true},
            {fixed: 'right', width: 165, align:'center', toolbar: '#bar'}
        ]]
    });
    
     // 链接列表
    linksIns = table.render({
        elem: '#links',
        height: 400,
        url: '/admin/links/getLinksList', //数据接口
        page: true, //开启分页
        totalRow: true, //开启合计行
        cols: [[ //表头
            {type: 'checkbox', fixed: 'left'},
            {field: 'id', title: '链接ID', width:80, sort: true, fixed: 'left'},
            {field: 'link_cate_title', title: '分类', width:80},
            {field: 'link_title', title: '名称', width: 100},
            {field: 'link', title: '链接地址', width: 240},
            //,{field: 'delete_time', title: '软删除时间', width:80},
            {field: 'update_time', title: '更新时间', width: 120, sort: true},
            {field: 'create_time', title: '创建时间', width: 120, sort: true},
            {fixed: 'right', width: 165, align:'center', toolbar: '#bar'}
        ]]
    });

    // 留言列表
    massageIns = table.render({
        elem: '#massage-list',
        height: 400,
        url: '/admin/massage/getmassagelist', //数据接口
        page: true, //开启分页
        cols: [[ //表头
            {type: 'checkbox', fixed: 'left'},
            {field: 'id', title: 'ID', width:80, sort: true, fixed: 'left'},
            {field: 'massage_title', title: '主题', width:160},
            {field: 'massage_text', title: '内容', width: 400},
            {field: 'contact', title: '联系方式', width: 400},
            // ,{field: 'delete_time', title: '删除时间', width:80},
            {field: 'update_time', title: '更新时间', width: 80, sort: true},
            {field: 'create_time', title: '创建时间', width: 80, sort: true},
            {fixed: 'right', width: 165, align:'center', toolbar: '#bar'}
        ]]
    });

    // 评论列表
    commentsIns = table.render({
        elem: '#comment-list',
        height: 400,
        url: '/admin/comments/getcommentslist', //数据接口
        page: true, //开启分页
        cols: [[ //表头
            {type: 'checkbox', fixed: 'left'},
            {field: 'id', title: 'ID', wridth:80, sort: true, fixed: 'left'},
            {field: 'user_id', title: '用户id', width:80},
            {field: 'blog_id', title: '博客id', width: 80},
            // {field: 'tag', title: '标签', width: 80},
            {field: 'comment_text', title: '内容', width:240},
            // {field: 'delete_time', title: '软删除时间', width:80} ,
            // {field: 'update_time', title: '更新时间', width: 80, sort: true},
            {field: 'create_time', title: '创建时间', width: 80, sort: true},
            // {field: 'operate', title: '操作', width: 150},
            {fixed: 'right', width: 165, align:'center', toolbar: '#bar'}
        ]]
    });
    //监听头工具栏事件
    table.on('toolbar(article)', function(obj){
    var checkStatus = table.checkStatus(obj.config.id),
        data = checkStatus.data; //获取选中的数据
    switch(obj.event){
        case 'add':
            layer.msg('添加');
            break;
        case 'update':
            if(data.length === 0){
              layer.msg('请选择一行');
            } else if(data.length > 1){
              layer.msg('只能同时编辑一个');
            } else {
              layer.alert('编辑 [id]：'+ checkStatus.data[0].id);
            }
            break;
        case 'delete':
            if(data.length === 0){
              layer.msg('请选择一行');
            } else {
              layer.msg('删除');
            }
            break;
        };
    });
  
    //监听博客列表行工具事件
    table.on('tool(article)', function(obj){ //注：tool 是工具条事件名，test 是 table 原始容器的属性 lay-filter="对应的值"
        var data = obj.data, //获得当前行数据
            layEvent = obj.event; //获得 lay-event 对应的值
        if(layEvent === 'detail'){
            window.open('/blog/detail/index/id/'+data.id);
        } else if(layEvent === 'del'){
            layer.confirm('真的删除行么', function(index){
                obj.del(); //删除对应行（tr）的DOM结构
                layer.close(index);
                deleteBlog(data.id);
            });
        }else if(layEvent === 'edit'){
            editBlog(data.id);
        }
    });

    //监听链接列表行工具事件
    table.on('tool(links)', function(obj){ //注：tool 是工具条事件名，test 是 table 原始容器的属性 lay-filter="对应的值"
        var data = obj.data, //获得当前行数据
            layEvent = obj.event; //获得 lay-event 对应的值
        if(layEvent === 'detail'){
            window.open(data.link);
        } else if(layEvent === 'del'){
            layer.confirm('确定删除此链接？', function(index){
                obj.del(); //删除对应行（tr）的DOM结构
                layer.close(index);
                deleteLink(data.id);
            });
        }else if(layEvent === 'edit'){
                editLink(data.id);
        }
    });

    //监听评论列表行工具事件
    table.on('tool(comments)', function(obj){ //注：tool 是工具条事件名，test 是 table 原始容器的属性 lay-filter="对应的值"
        var data = obj.data, //获得当前行数据
            layEvent = obj.event; //获得 lay-event 对应的值
        if(layEvent === 'detail'){
            layer.msg(data.comment_text);
        } else if(layEvent === 'del'){
            layer.confirm('确定删除此评论？', function(index){
                obj.del();
                layer.close(index);
                deleteComment(data.id);
            });
        }else if(layEvent === 'edit'){
            layer.msg('暂无此功能');
        }
    });
    // 获取开关值
    form.on('switch(web-status)', function(data){
        var webStatus = Number(data.elem.checked);
        postData('/admin/web/webstatus','POST', {'web_status':webStatus});
        $('#close-web').slideToggle();
    });
});

// 初始化wangEditor
var E = window.wangEditor;
var editor = new E('#editor');
editor.create();

var domain = $('input[name="domain"]'),
ipSet = $('input[name="ipset"]'),
beiAn = $('input[name="beian"]'),
blogId = $('input[name="id"]'),
blogTitle = $('input[name="blog_title"]'),
blogUniqueTag = $('input[name="unique_tag"]'),
linkId = $('input[name="link_id"]'),
linkTitle = $('input[name="link_title"]'),
linkAddress = $('input[name="link_address"]');

// 所有数据前端不验证，后端验证数据合法性
$(function(){
    // 分类管理
    $('#manage-classification').click(function(){
        getCateData();
    });
    // 权限管理
    $('#auth-manage').click(function(){
        getAuthData();
    });
    // 关闭网站显示信息
    $("#close-info").click(function() {
        var closeData = {'id':1,'close_info':$('#close-info-data').val()}
        postData('/admin/web/editweb','POST',closeData);
        return false;
    });
    // 修改网站信息
    $("#info-btn").click(function() {
        var webData = {'id':1,'domain':domain.val(),'ip':ipSet.val(),'beian_code':beiAn.val()}
        postData('/admin/web/editweb','POST',webData);
        return false;
    });

    // 发布文章
    // 自动保存
    $(".w-e-text").on('keyup click mouseleave',function(){
        autoSave();
    });

    // 编辑html数据
    $("#btn1").click(function(){
        layer.open({
            type: 1,
            title: '请在此处输入文章的html页面',
            area: ['500px', '300px'],
            content: '<textarea id="html-page" style="width:500px;height:300px"></textarea>',
            btn: ['提交'],
            yes: function(index, layero){
                editHtml();
                layer.close(index);
            }
        });
        return false;
    });

    // 显示编辑器文本
    $("#btn2").click(function(){
         alert(editor.txt.text());
         return false;
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

    // 提交链接数据
    $("#btn5").click(function(){
        postData('/admin/links/createlinks', 'POST',getLocalLinkData());
        return false;
    });

    // 修改链接数据
    $("#btn6").click(function(){
        postData('/admin/links/editlinks', 'POST',getLocalLinkData());
        $("#btn6").hide();
        $("#btn5").show();
        return false;
    });
});

/* 
** 处理函数
**
**
** 处理函数
 */

// 载入html
function editHtml(){
    $(".w-e-text").append($('#html-page').val());
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
            }
        });
    }
}
// 删除文章
function deleteBlog(id){
    deleteBlogData('/admin/blog/deleteblog','POST',{'id':id});
}
// 删除链接
function deleteLink(id){
    deleteLinkData('/admin/links/deletelink','POST',{'id':id});
}
// 删除评论
function deleteComment(id){
    deleteCommentData('/admin/comments/deletecomments','POST',{'id':id});
}

// 清空博客内容
function emptyBlogData(){
    blogId.val("");
    blogTitle.val("");
    blogUniqueTag.val("");
    $(".w-e-text").empty();
}

// 编辑时填充数据到文章编辑页
function fillBlogData(data){
    blogId.val(data["data"]["id"]);
    blogTitle.val(data["data"]["blog_title"]);
    blogUniqueTag.val(data["data"]["unique_tag"]);
    $(".w-e-text").append(data["data"]["blog_html"]);
}

// 编辑链接
function editLink(id){
    getLinkData('/admin/links/querylink','GET',{'id':id});
    $("#btn5").hide();
    $("#btn6").show();
}

// 清空链接内容
function emptyLinkData(){
    linkId.val("");
    linkTitle.val("");
    linkAddress.val("");
}

// 编辑时填充数据到链接编辑页
function fillLinkData(data){
    console.log(data["data"]);
    linkId.val(data["data"]["id"]);
    linkTitle.val(data["data"]["link_title"]);
    linkAddress.val(data["data"]["link"]);
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
    data["unique_tag"] = blogUniqueTag.val();
    data["cate_id"] =  $('input[name="blog-category"]:checked').val();
    data["blog_html"] = editor.txt.html();
    data["blog_text"] = editor.txt.text();
    var blogData = {"blogdata":data, "tagdata":tagData};
    console.log(blogData);
    return blogData;
}

// 获取链接数据
function getLocalLinkData(){
    var data = {};
    data["id"] = linkId.val();
    data["link_cate_id"] = $('input[name="link_cate"]:checked').val();
    data["link_title"] = linkTitle.val();
    data["link"] = linkAddress.val();
    return data;
}

//自动保存博客数据,id为1
function autoSave(){
    var tempData = getlocalData();
    tempData["blogdata"]["id"] = 1;
    postData('/admin/blog/editblog','POST',tempData);
}

// 提交数据(保存博客、编辑博客、保存链接、编辑链接)
function postData(url,method,data){
    $.ajax({
        type:method || 'POST',
        url:url,
        data:data,
        dataType:'json',
        success: function(data){
            // 所有后台回调操作
            if(data.msg == "自动保存完成"){
                // pass
            }else if(data.msg.indexOf("网站") == -1){
                layer.msg(data.msg);
                emptyLinkData();
                emptyBlogData();
                articleIns.reload();
                linksIns.reload();
            }else{
                layer.msg(data.msg);
            }
        },error:function(data){
            layer.msg("请求失败");
        }
    });
}

// 根据id查询博客数据,编辑时填充调用
function getBlogData(url,method,data){
    $.ajax({
        type:method || 'GET',
        url:url,
        data:data,
        dataType:'json',
        success: function(data){
            emptyBlogData();
            fillBlogData(data);
        }
    });
}

// 根据id查询链接数据,编辑时填充调用
function getLinkData(url,method,data){
    $.ajax({
        type:method || 'GET',
        url:url,
        data:data,
        dataType:'json',
        success: function(data){
            // 填充数据到编辑器
            emptyLinkData();
            console.log(data);
            fillLinkData(data);
        }
    });
}

// 根据id删除博客
function deleteBlogData(url,method,data){
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
}

// 根据id删除链接
function deleteLinkData(url,method,data){
    $.ajax({
        type:method || 'POST',
        url:url,
        data:data,
        dataType:'json',
        success: function(data){
            layer.msg(data.msg);
            linksIns.reload();
        }
    });
}

// 根据id删除评论
function deleteCommentData(url,method,data){
    $.ajax({
        type:method || 'POST',
        url:url,
        data:data,
        dataType:'json',
        success: function(data){
            layer.msg(data.msg);
            commentsIns.reload();
        }
    });
}

// 获取分类框数据
function getCateData(){
    layer.open({
        type: 2,
        skin: 'massageboard-class',
        area: ['850px','500px'],
        title: '<div><b>分类管理</b></div>',
        content: ['/admin/cate/index','yes'],
        btn: ['刷新父页面使修改生效'],
        yes: function(index, layero){
            layer.close(index);
            location.reload(true);
        }
    });
}

// 获取权限数据
function getAuthData(){
 layer.open({
        type: 2,
        skin: 'massageboard-class',
        area: ['850px','500px'],
        title: '<div><b>权限管理</b></div>',
        content: ['/admin/auth/index','yes'],
        btn: ['刷新父页面使修改生效'],
        yes: function(index, layero){
            layer.close(index);
            location.reload(true);
        }
    });
}