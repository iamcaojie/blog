//初始化layui
layui.use(['layer'], function(){
    var layer = layui.layer;
});
$(function(){
    // 修改头像
    $(".edit-avatar").click(function () {
        $("#edit").toggle();
        var imgSrc = $("#edit-avatar-img").attr('src');
        console.log(imgSrc);
        $("#avatar").attr('src',imgSrc);
    });
    // 点击修改昵称
     $("#nickname").click(function(){
         $(this).hide();
         $(this).next().attr('type','text');
         $(this).next().focus();
         $(this).next().select();
     });
     // 移出修改完成
    $('input[name="nickname"]').blur(function () {
        $(this).attr('type','hidden');
        $(this).prev().show();
        var nickName = $(this).val();
        console.log(nickName);
        if(!(nickName == '')){
            // 修改昵称
            $.post('/user/index/nickname',{'nickname':nickName},function (data,status) {
                if(data.code === 0){
                    $("#nickname").text(data.msg);
                }else{
                    layer.msg(data.msg);
                }
            });
        }else{
            $("#nickname").text('点击修改昵称');
        }
    });
    // 切换
    $("#channel .item").click(function(){
        var index = $(this).index();
        console.log(index);
        $('#content').children().eq(index).show().siblings().hide();
    });
    // 删除文章
    $(".delete-blog").click(function(){
        var that = $(this);
        var blogId = $(this).attr('data');
        layer.confirm('确定删除此文章？', function(index){
            $.post('/user/action/deleteBlog',{'id':blogId},function (data,status) {
                if (data.code === 0) {
                    that.parent().hide();
                    layer.msg(data.msg);
                } else {
                    layer.msg(data.msg);
                }
            });
        });
    });
    // 删除评论
    $(".delete-comment").click(function(){
        var that = $(this);
        var commentId = $(this).attr('data');
        layer.confirm('确定删除此评论？', function(index){
            $.post('/user/action/deleteComment',{'id':commentId},function (data,status) {
                if (data.code === 0) {
                    that.parent().hide();
                    layer.msg(data.msg);
                } else {
                    layer.msg(data.msg);
                }
            });
        });
    });
    // 取消收藏
    $(".delete-favorite").click(function(){
        var that = $(this);
        var favoriteId = $(this).attr('data');
        layer.confirm('确定取消收藏？', function(index){
            $.post('/user/action/deleteFavorite',{'id':favoriteId},function (data,status) {
                if (data.code === 0) {
                    that.parent().hide();
                    layer.msg(data.msg);
                } else {
                    layer.msg(data.msg);
                }
            });
        });
    });
});