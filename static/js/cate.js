layui.use(['layer','form','element','table'], function() {
    var layer = layui.layer,
    form = layui.form,
    element = layui.element,
    table = layui.table;
    // 文章列表
    cateIns = table.render({
        elem: '#catebox',
        height: 470,
        url: '/admin/cate/getcatetreelist', //数据接口
        page: true, //开启分页
        cols: [[ //表头
            {field: 'id', title: '分类ID', width:80, sort: true, fixed: 'left'},
            {field: 'p_blog_category', title: '分类', width:100, sort: true},
            {field: 'cate_detail', title: '分类详情', width:200, sort: true},
            {field: 'pid_name', title: '所属分类', width:100},
            // {field: 'delete_time', title: '删除时间', width:80},
            // {field: 'update_time', title: '更新时间', width: 80, sort: true},
            // {field: 'create_time', title: '创建时间', width: 80, sort: true},
            {fixed: 'right', width: 300, align:'center', toolbar: '#bar'}
        ]]
    });
    //监听博客列表行工具事件
    table.on('tool(catebox)', function(obj){
        var data = obj.data,
            layEvent = obj.event;
        if(layEvent === 'edit'){
            layer.open({
                type: 1,
                title:'编辑分类',
                area: ['300px', '250px'],
                content: '<label style="margin: 10px;">分类名称</label><input class="layui-input" name="cate-data" autocomplete="off" value="'+data['blog_category']+'"/>'+
                '<br><label style="margin: 10px;">分类详情</label><input class="layui-input" name="cate-detail-data" autocomplete="off" value="'+data['cate_detail']+'"/>',
                btn: ['修改'],
                btnAlign: 'c',
                yes:function(index, layero) {
                    editCate('/admin/cate/editcate', 'POST', {'id':data.id,'blog_category':$('input[name="cate-data"]').val(),'cate_detail':$('input[name="cate-detail-data"]').val()});
                    layer.close(index);
                }
            });
        } else if(layEvent === 'sdel'){
            layer.confirm('确定隐藏分类吗？<br>此操作将会隐藏此分类以及所有子分类！！！<br>被隐藏分类下的所有文章分类正常显示', function(index){
                editCate('/admin/cate/signdeletecate', 'POST', {'id':data.id});
                layer.close(index);
            });
        }else if(layEvent === 'adel'){
            layer.confirm('确定<span style="color:red">完全删除分类</span>吗？(无法撤销！！！)<br>此操作将会删除此分类以及所有子分类！！！<br>被删除分类下的所有文章分类将会归类到"无"', function(index){
                // layer.msg('此功能已禁用');
                editCate('/admin/cate/deletecate', 'POST', {'id':data.id});
                layer.close(index);
            });
        }
    });
});

$(function() {
    // 显示分类
    $('#recover-btn').click(function () {
        $.get('/admin/cate/recover', function (data) {
            layer.msg(data.msg);
            if (data.code === 0) {
                cateIns.reload();
            }
        });
        return false;
    });
    $('#refresh-btn').click(function () {
        location.reload(true);
    });
    $('form').submit(function () {
        if($('input[name="blog_category"]').val() === ""){
            layer.msg('请输入分类名称');
            return false;
        }
    });
});

function editCate(url, method, data) {
    $.ajax({
        type:method || 'POST',
        url:url,
        async:false,
        data:data,
        dataType:'json',
        success: function(data){
            layer.msg(data.msg);
            if(data.code==0){
                cateIns.reload();
            }
        }
    });
}