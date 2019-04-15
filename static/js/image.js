layui.use(['layer','element'], function() {
    var layer = layui.layer,
    element = layui.element;
});

$(function() {
    // 显示操作栏
    $('.img-box').hover(function () {
        $(this).find('.operate').toggle();
        $(this).find('.operate-big').toggle();
    });
    // 放大
    $(document).on('click','.image', function () {
        $(this).parent().siblings().hide();
        $(this).siblings().addClass('operate-big');
        $(this).siblings().removeClass('operate');
        $(this).addClass('bigimage');
        $(this).removeClass('image');
    });
    // 缩小
    $(document).on('click','.bigimage', function () {
        $(this).parent().siblings().show();
        $(this).siblings().addClass('operate');
        $(this).siblings().removeClass('operate-big');
        $(this).addClass('image');
        $(this).removeClass('bigimage');
    });
    $('.delete-btn').click(function () {
        var id = $(this).parent().attr('data');
        layer.confirm('确定删除此图片？', function(index){
            deleteImage(id);
            layer.close(index);
        });
    });
});

// 删除轮播图
function deleteImage(id) {
    $.ajax({
        type:'POST',
        url:'/admin/image/deleteImage',
        data:{'id':id},
        dataType:'json',
        success: function(data){
            layer.msg(data.msg);
            if(data.code == 0){
                window.location.reload();
            }
        },error:function(data){
            layer.msg("请求失败");
        }
    });
}