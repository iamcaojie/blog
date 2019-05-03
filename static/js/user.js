$(function(){
    // 切换
    $("#channel .item").click(function(){
        var index = $(this).index();
        $('#content').children().eq(index).show().siblings().hide();
    });
});