layui.use(['layer','form','element','table'], function() {
    var layer = layui.layer,
    form = layui.form,
    element = layui.element,
    table = layui.table;
    // 文章列表
    cateIns = table.render({
        elem: '#catebox',
        height: 400,
        url: '/admin/cate/getcatetreelist', //数据接口
        page: true, //开启分页
        cols: [[ //表头
            {field: 'id', title: '分类ID', width:80, sort: true, fixed: 'left'},
            {field: 'blog_category', title: '分类', width:200, sort: true},
            {field: 'pid_name', title: '所属分类', width:200},
            // {field: 'delete_time', title: '删除时间', width:80},
            // {field: 'update_time', title: '更新时间', width: 80, sort: true},
            // {field: 'create_time', title: '创建时间', width: 80, sort: true},
            {fixed: 'right', width: 200, align:'center', toolbar: '#bar'}
        ]]
    });
    //监听博客列表行工具事件
    table.on('tool(catebox)', function(obj){ //注：tool 是工具条事件名，test 是 table 原始容器的属性 lay-filter="对应的值"
        var data = obj.data, //获得当前行数据
            layEvent = obj.event; //获得 lay-event 对应的值
        if(layEvent === 'edit'){
            layer.msg('编辑');
        } else if(layEvent === 'sdel'){
            layer.confirm('真的删除行么', function(index){
                // obj.del(); //删除对应行（tr）的DOM结构
                layer.msg('删除');
                layer.close(index);
            });
        }else if(layEvent === 'adel'){
            layer.msg('全部删除');
        }
    });
});
