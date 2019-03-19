layui.use(['layer','form','element','table'], function() {
    var layer = layui.layer,
    form = layui.form,
    element = layui.element,
    table = layui.table;
    // 权限列表
    authRuleIns = table.render({
        elem: '#authbox',
        height: 470,
        url: '/admin/auth/queryAuthRule', //数据接口
        page: true, //开启分页
        cols: [[ //表头
            {field: 'id', title: '分类ID', width:80, sort: true, fixed: 'left'},
            {field: 'p_title', title: '权限名称', width:200, sort: true},
            {field: 'name', title: '权限标识', width:200, sort: true},
            {field: 'pid_name', title: '所属分类', width:100},
            {field: 'status', title: '状态', width:60},
            // {field: 'delete_time', title: '删除时间', width:80},
            // {field: 'update_time', title: '更新时间', width: 80, sort: true},
            // {field: 'create_time', title: '创建时间', width: 80, sort: true},
            {fixed: 'right', width: 120, align:'center', toolbar: '#bar'}
        ]]
    });
    //监听权限列表行工具事件
    table.on('tool(authbox)', function(obj){
        var data = obj.data,
            layEvent = obj.event;
        if (layEvent === 'edit') {
            layer.open({
                type: 1,
                title:'编辑权限',
                area: ['300px', '250px'],
                content: '<label style="margin: 10px;">权限名称</label><input class="layui-input" name="auth-data" autocomplete="off" value="'+data['title']+'"/>'+
                '<br><label style="margin: 10px;">权限标识</label><input class="layui-input" name="auth-detail-data" autocomplete="off" value="'+data['name']+'"/>',
                btn: ['修改'],
                btnAlign: 'c',
                yes:function(index, layero) {
                    editAuthRule('/admin/auth/editAuthRule', 'POST', {'id':data.id,'title':$('input[name="auth-data"]').val(),'name':$('input[name="auth-detail-data"]').val()});
                    layer.close(index);
                }
            });
        } else if(layEvent === 'del'){
            layer.confirm('确定删除' + data.title + '权限吗？', function(index) {
                editAuthRule('/admin/auth/deleteAuthRule', 'POST', {'id': data.id});
                layer.close(index);
            });
        }
    });

    // 用户组列表
    groupIns = table.render({
        elem: '#groupbox',
        height: 470,
        url: '/admin/auth/queryAuthGroup', //数据接口
        page: true, //开启分页
        cols: [[ //表头
            {field: 'id', title: '用户组ID', width:80, sort: true, fixed: 'left'},
            {field: 'p_title', title: '用户组名称', width:200, sort: true},
            {field: 'rules_title', title: '用户组拥有权限', width:200, sort: true},
            {field: 'pid', title: '所属分类', width:100},
            {field: 'status', title: '状态', width:60},
            // {field: 'delete_time', title: '删除时间', width:80},
            // {field: 'update_time', title: '更新时间', width: 80, sort: true},
            // {field: 'create_time', title: '创建时间', width: 80, sort: true},
            {fixed: 'right', width: 120, align:'center', toolbar: '#bar'}
        ]]
    });
    //监听用户组列表行工具事件
    table.on('tool(groupbox)', function(obj){
        var data = obj.data,
            layEvent = obj.event;
        if (layEvent === 'edit') {
            layer.open({
                type: 1,
                title:'编辑用户组',
                area: ['300px', '250px'],
                content: '<label style="margin: 10px;">用户组名称</label><input class="layui-input" name="group-data" autocomplete="off" value="'+data['title']+'"/>' +
                '<label style="margin: 10px;">用户组权限，开发中</label>',
                btn: ['修改'],
                btnAlign: 'c',
                yes:function(index, layero) {
                    var editData = {'id':data.id,'title':$('input[name="group-data"]').val()};
                    editGroup('/admin/auth/editAuthGroup', 'POST', editData);
                    layer.close(index);
                }
            });
        } else if(layEvent === 'del'){
            layer.confirm('确定删除' + data.title + '用户组吗？', function(index) {
                editGroup('/admin/auth/deleteAuthGroup', 'POST', {'id': data.id});
                layer.close(index);
            });
        }
    });

    // 用户列表
    userIns = table.render({
        elem: '#userbox',
        height: 470,
        url: '/admin/auth/queryUser', //数据接口
        page: true, //开启分页
        cols: [[ //表头
            {field: 'id', title: '用户ID', width:80, sort: true, fixed: 'left'},
            {field: 'nickname', title: '昵称', width:200, sort: true},
            {field: 'username', title: '账号', width:200, sort: true},
            {field: 'pid', title: '所属用户组', width:100},
            // {field: 'delete_time', title: '删除时间', width:80},
            // {field: 'update_time', title: '更新时间', width: 80, sort: true},
            // {field: 'create_time', title: '创建时间', width: 80, sort: true},
            {fixed: 'right', width: 120, align:'center', toolbar: '#bar'}
        ]]
    });
    //监听用户列表行工具事件
    table.on('tool(userbox)', function(obj){
        var data = obj.data,
            layEvent = obj.event;
        if (layEvent === 'edit') {
            layer.open({
                type: 1,
                title:'编辑用户',
                area: ['300px', '250px'],
                content: '<label style="margin: 10px;">账号</label><input class="layui-input" name="username-data" autocomplete="off" value="'+data['username']+'"/>' +
                '<label style="margin: 10px;">密码</label><input class="layui-input" name="password-data" autocomplete="off" value=""/>',
                btn: ['修改'],
                btnAlign: 'c',
                yes:function(index, layero) {
                    var editData = {'id':data.id, 'title':$('input[name="group-data"]').val()};
                    editUser('/admin/auth/editUser', 'POST', editData);
                    layer.close(index);
                }
            });
        } else if(layEvent === 'del'){
            layer.confirm('确定删除' + data.username + '用户吗？', function(index) {
                editUser('/admin/auth/deleteUser', 'POST', {'id': data.id});
                layer.close(index);
            });
        }
    });
});
var groupTitle = $('input[name="group-title"]'),
    userName = $('input[name="username"]'),
    passWord = $('input[name="password"]');

$(function() {
    // 显示隐藏分类
    $('#recover-btn').click(function () {
        $.get('/admin/cate/recover', function (data) {
            layer.msg(data.msg);
            if (data.code === 0) {
                cateIns.reload();
            }
        });
        return false;
    });

    // 重载权限表格
    $('#refresh-btn').click(function () {
        location.reload(true);
    });

    // 重载用户组表格
    $('#refresh-btn').click(function () {
        location.reload(true);
    });

    // 重载用户表格
    $('#refresh-btn').click(function () {
        location.reload(true);
    });

    // 添加用户权限
    $('#add-auth-form').submit(function () {
        if($('input[name="title"]').val() === ""){
            layer.msg('请输入权限名称');
            return false;
        }else if($('input[name="name"]').val() === ""){
            layer.msg('请输入权限标识');
            return false;
        }
    });

    // 添加分组
    $('#add-group-btn').click(function () {
        editGroup('/admin/auth/addAuthGroup','POST',getGroupData());
        return false;
    });

    // 添加用户
    $('#add-user-btn').click(function () {
        editUser('/admin/auth/addUser','POST',getUserData());
        console.log(getUserData());
        return false;
    })
});

// 获取分组数据
function getGroupData() {
    var groupTitleData = groupTitle.val();
    var groupRulesData = '';
    $('input:checkbox:checked').each(function() {
        // groupRulesData.push($(this).val()); // 数组用法
        groupRulesData = groupRulesData + ($(this).val()) + ',';
    });
    groupRulesData = groupRulesData.substr(0,groupRulesData.length-1);
    var groupStatusData = $('input[name="group-status"]:checked').val();
    return {'title':groupTitleData,'rules':groupRulesData,'status':groupStatusData}
}

// 获取用户数据
function getUserData(){
    return {'username':userName.val(),'password':hex_md5(passWord.val())};
}

function editAuthRule(url, method, data) {
    $.ajax({
        type:method || 'POST',
        url:url,
        async:false,
        data:data,
        dataType:'json',
        success: function(data){
            layer.msg(data.msg);
            if(data.code === 0){
                authRuleIns.reload();
            }
        }
    });
}

// 编辑用户组数据
function editGroup(url, method, data) {
    $.ajax({
        type:method || 'POST',
        url:url,
        async:false,
        data:data,
        dataType:'json',
        success: function(data){
            layer.msg(data.msg);
            if(data.code === 0){
                if(data.msg !== '用户组添加成功'){
                    layer.msg(data.msg);
                    groupIns.reload();
                }else{
                    location.reload(true);
                }
            }
        }
    });
}

// 编辑
function editUser(url, method, data) {
    $.ajax({
        type:method || 'POST',
        url:url,
        async:false,
        data:data,
        dataType:'json',
        success: function(data){
            layer.msg(data.msg);
            if(data.code === 0){
                userIns.reload();
            }
        }
    });
}